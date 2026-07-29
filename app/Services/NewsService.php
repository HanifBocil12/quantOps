<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class NewsService
{
    protected array $rssFeeds = [];

    protected array $onchainAlertSources = [
        'whale_alert_io',
    ];

    public function getNews(int $limit = 20): array
    {
        $allNews = array_merge(
            $this->getRssNews(),
            Cache::get('telegram_news', [])
        );

        $allNews = $this->filterNews($allNews);

        usort($allNews, fn($a, $b) => $b['published'] - $a['published']);

        $allNews = array_slice($allNews, 0, $limit);

        return $this->categorizeGeneralNews($allNews);
    }

    /**
     * Ambil crypto news, udah dipisah jadi 2 grup: onchain_alert & general.
     */
    public function getCryptoNewsGrouped(int $limitPerGroup = 10): array
    {
        $allNews = array_merge(
            $this->getRssNews(),
            Cache::get('telegram_news', [])
        );

        $allNews = $this->filterNews($allNews);
        $allNews = $this->categorizeNews($allNews);

        usort($allNews, fn($a, $b) => $b['published'] - $a['published']);

        $onchainAlert = array_values(array_filter($allNews, fn($n) => $n['category'] === 'onchain_alert'));
        $general = array_values(array_filter($allNews, fn($n) => $n['category'] === 'general'));

        return [
            'onchain_alert' => array_slice($onchainAlert, 0, $limitPerGroup),
            'general'       => array_slice($general, 0, $limitPerGroup),
        ];
    }

    public function getWorldNews(int $limit = 20): array
    {
        $allNews = array_merge(
            $this->getRssNews(),
            Cache::get('telegram_world_news', [])
        );

        $allNews = $this->filterNews($allNews);

        usort($allNews, fn($a, $b) => $b['published'] - $a['published']);

        return array_slice($allNews, 0, $limit);
    }

    protected function categorizeNews(array $news): array
    {
        foreach ($news as &$item) {
            $item['category'] = in_array($item['source'], $this->onchainAlertSources)
                ? 'onchain_alert'
                : 'general';
        }

        return $news;
    }

    protected function filterNews(array $news): array
    {
        // 1. Buang noise price-alert generik ("Bitcoin pumps/rips to $X")
        $noisePatterns = [
            '/bitcoin (pumps|rips|dumps|drops) to \$?[\d,]+/i',
            '/^just in: bitcoin (rises|falls|jumps) to/i',
        ];

        $news = array_filter($news, function ($item) use ($noisePatterns) {
            foreach ($noisePatterns as $pattern) {
                if (preg_match($pattern, $item['title'])) {
                    return false;
                }
            }
            return true;
        });

        // 2. Dedupe berdasarkan title yang mirip (bukan exact match,
        //    karena judul sering ada emoji/whitespace beda dikit)
        $seen = [];
        $deduped = [];

        foreach ($news as $item) {
            $normalized = $this->normalizeTitle($item['title']);

            if (isset($seen[$normalized])) {
                continue;
            }

            $seen[$normalized] = true;
            $deduped[] = $item;
        }

        return array_values($deduped);
    }

    protected function normalizeTitle(string $title): string
    {
        $clean = preg_replace('/[^\p{L}\p{N}\s]/u', '', $title);
        $clean = mb_strtolower(trim($clean));

        // Samain semua whitespace (termasuk newline) jadi 1 spasi
        $clean = preg_replace('/\s+/', ' ', $clean);

        // Buang boilerplate: nama source + prefix generik ("just in", "new", "breaking")
        // biar fingerprint mulai dari konten yang beneran beda-beda per tweet
        $clean = preg_replace('/^(bitcoin magazine )?(twitterx )?(just in|new|breaking) ?/', '', $clean);

        // Naikin ke 10 kata karena sekarang budget-nya dipake buat konten asli,
        // bukan kehabisan di boilerplate
        return implode(' ', array_slice(explode(' ', $clean), 0, 10));
    }

    public function getWarNews(int $limit = 20): array
    {
        $allNews = array_merge(
            $this->getRssNews(),
            Cache::get('telegram_war_news', [])
        );

        $allNews = $this->filterNews($allNews);

        usort($allNews, fn($a, $b) => $b['published'] - $a['published']);

        return array_slice($allNews, 0, $limit);
    }

    protected function getRssNews(): array
    {
        $allNews = [];

        foreach ($this->rssFeeds as $source => $url) {
            try {
                $response = Http::timeout(5)->get($url);
                if ($response->failed()) continue;

                $xml = simplexml_load_string($response->body());
                if (!$xml || !isset($xml->channel->item)) continue;

                foreach ($xml->channel->item as $item) {
                    $allNews[] = [
                        'source'    => $source,
                        'title'     => (string) $item->title,
                        'url'       => (string) $item->link,
                        'published' => strtotime((string) $item->pubDate),
                    ];
                }
            } catch (\Exception $e) {
                Log::warning("RSS fetch failed for {$source}: " . $e->getMessage());
                continue;
            }
        }

        return $allNews;
    }
    public function getLiveWebcams(): array
    {
        return Cache::remember(
            'youtube_live_webcams',
            now()->addHours(6), // dari 15 menit -> 6 jam, ini yg paling nentuin hemat quota
            function () {
                return $this->fetchLiveWebcams();
            }
        );
    }

    public function resolveChannelHandles(): void
    {
        $handles = [
            'Sky News' => 'SkyNews',
            'Euronews' => 'euronews',
            'CNA' => 'channelnewsasia',
            'Al Jazeera English' => 'AlJazeeraEnglish',
            'NASA' => 'NASA',
        ];

        foreach ($handles as $label => $handle) {
            $response = Http::get('https://www.googleapis.com/youtube/v3/channels', [
                'key' => env('YOUTUBE_API_KEY_1'),
                'forHandle' => $handle,
                'part' => 'snippet',
            ]);

            $item = $response->json('items.0');

            if ($item) {
                dump("{$label} (@{$handle}) => ID: {$item['id']} | Title: {$item['snippet']['title']}");
            } else {
                dump("{$label} (@{$handle}) => NOT FOUND");
            }
        }
    }

    public function validateChannelIds(): void
    {
        $ids = [
            'UC9Ad5PzjArHpf3P2rwFNcVg',
            'UCupvZG-5ko_eiXAupbDfxWw',
            'UCX6OQ3DkcsbYNE6H8uQQuVA',
            'UCknLrEdhRCp1aegoMqRaCZg',
            'UCBi2mrWuNuyYy4gbM6fU18Q',
            'UCXeB_-XGzPjOmc5aOwGHC9A',
            'UC8oWZuLFc_eBA0LmgWFA2Rw',
            'UCXU9Y8T4pLOu1T7GjVxJ2WQ',
            'UCp7UxMxM5sNfWjqX9Yj2R_w',
            'UCQjdC2VqN_L3c1Ml4XQd3Jg',
            'UCRuCgmzhczsm89jzPtN2Wuw',
        ];

        $response = Http::get('https://www.googleapis.com/youtube/v3/channels', [
            'key' => env('YOUTUBE_API_KEY_1'),
            'id' => implode(',', $ids),
            'part' => 'snippet',
        ]);

        dump('STATUS: ' . $response->status());
        dump($response->json());
    }

    private function fetchLiveWebcams(): array
    {
        $cityChannels = [

            // EUROPE
            'London' => [
                'region' => 'Europe',
                'channels' => [
                    'UCoMdktPbSTixAyNGwb-UYkQ', // Sky News
                    'UCupvZG-5ko_eiXAupbDfxWw', // CNN
                ]
            ],
            'Frankfurt' => [
                'region' => 'Europe',
                'channels' => [
                    'UCSrZ3UV4jOidv8ppoVuvW9Q', // Euronews
                    'UCupvZG-5ko_eiXAupbDfxWw', // CNN
                ]
            ],
            'Berlin' => [
                'region' => 'Europe',
                'channels' => [
                    'UCSrZ3UV4jOidv8ppoVuvW9Q', // Euronews
                    'UCknLrEdhRCp1aegoMqRaCZg', // DW News
                ]
            ],

            // AMERICAS
            'New York' => [
                'region' => 'Americas',
                'channels' => [
                    'UCupvZG-5ko_eiXAupbDfxWw', // CNN
                    'UCBi2mrWuNuyYy4gbM6fU18Q', // ABC News
                ]
            ],
            'Washington DC' => [
                'region' => 'Americas',
                'channels' => [
                    'UCBi2mrWuNuyYy4gbM6fU18Q', // ABC News
                    'UCupvZG-5ko_eiXAupbDfxWw', // CNN
                ]
            ],

            // ASIA
            'Tokyo' => [
                'region' => 'Asia',
                'channels' => [
                    'UCXeB_-XGzPjOmc5aOwGHC9A', // TOKYO Live Camera TV (valid, tapi street journalism vibe)
                ]
            ],
            'Singapore' => [
                'region' => 'Asia',
                'channels' => [
                    'UC83jt4dlz1Gjl58fzQrrKZg', // CNA
                ]
            ],
            'Hong Kong' => [
                'region' => 'Asia',
                'channels' => [
                    'UCNye-wNBqNL5ZzHSJj3l8Bg', // Al Jazeera English
                    'UC83jt4dlz1Gjl58fzQrrKZg', // CNA
                ]
            ],

            // MIDDLE EAST
            'Dubai' => [
                'region' => 'Middle East',
                'channels' => [
                    'UCNye-wNBqNL5ZzHSJj3l8Bg', // Al Jazeera English
                    'UCSrZ3UV4jOidv8ppoVuvW9Q', // Euronews
                ]
            ],

            // SPACE
            'ISS Live' => [
                'region' => 'Space',
                'channels' => [
                    'UCLA_DiR1FfKNvjuUpBHmylQ', // NASA
                ]
            ],

        ];

        $result = [];

        foreach ($cityChannels as $city => $config) {

            $video = null;

            foreach ($config['channels'] as $channelId) {

                $video = $this->searchYoutubeLive($channelId);

                if ($video) {
                    logger("FOUND {$city}");
                    break;
                }
            }

            $result[] = [
                'city' => $city,
                'region' => $config['region'],
                'title' => $video['title'] ?? 'Offline',
                'video_id' => $video['videoId'] ?? null,
                'thumbnail' => $video['thumbnail'] ?? null,
                'status' => $video['status'] ?? 'offline',
            ];
        }

        return $result;
    }

    protected function getYoutubeKeys(): array
    {
        return array_values(array_filter([
            env('YOUTUBE_API_KEY'),
            env('YOUTUBE_API_KEY_1'),
        ]));
    }

    protected function searchYoutubeLive(string $channelId): ?array
    {
        $keys = $this->getYoutubeKeys();

        if (empty($keys)) {
            logger()->error('No YouTube API keys configured');
            return null;
        }

        $quotaReasons = ['quotaExceeded', 'rateLimitExceeded', 'dailyLimitExceeded', 'userRateLimitExceeded'];

        foreach ($keys as $index => $key) {

            $response = Http::get(
                'https://www.googleapis.com/youtube/v3/search',
                [
                    'key' => $key,
                    'channelId' => $channelId,
                    'part' => 'snippet',
                    'eventType' => 'live',
                    'type' => 'video',
                    'maxResults' => 1,
                ]
            );

            if ($response->successful()) {

                $data = $response->json();

                if (empty($data['items'])) {
                    return null;
                }

                $item = $data['items'][0];

                return [
                    'videoId' => $item['id']['videoId'],
                    'title' => $item['snippet']['title'],
                    'thumbnail' => $item['snippet']['thumbnails']['high']['url'] ?? null,
                    'status' => 'live',
                ];
            }

            $reason = $response->json('error.errors.0.reason');

            // Tangkep status 429 (Too Many Requests) juga sebagai sinyal quota,
            // selain cocokin reason string
            if ($response->status() === 429 || in_array($reason, $quotaReasons)) {
                logger()->warning("YouTube key #{$index} quota/rate limit hit, trying next key", [
                    'channelId' => $channelId,
                    'reason' => $reason,
                ]);
                continue;
            }

            logger()->error('Youtube API Error', [
                'status' => $response->status(),
                'body' => $response->json(),
                'channelId' => $channelId,
            ]);

            return null;
        }

        logger()->error("All YouTube API keys exhausted for channel: {$channelId}");

        return null;
    }

    protected function categorizeGeneralNews(array $news): array
    {
        return [
            'live' => [],        // TODO: isi nanti
            'markets' => [],      // TODO: isi nanti
        ];
    }
}
