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
        $channels = [

            // EUROPE
            [
                'city' => 'London',
                'region' => 'Europe',
                'channel_id' => 'UC9Ad5PzjArHpf3P2rwFNcVg', // Sky News (sering live)
            ],
            [
                'city' => 'Frankfurt',
                'region' => 'Europe',
                'channel_id' => 'UCkI2PJgVjH3tq3nJ1V5z9Xw', // Reuters (sering live)
            ],
            [
                'city' => 'Berlin',
                'region' => 'Europe',
                'channel_id' => 'UCkI2PJgVjH3tq3nJ1V5z9Xw', // Reuters
            ],

            // AMERICAS
            [
                'city' => 'New York',
                'region' => 'Americas',
                'channel_id' => 'UCupvZG-5ko_eiXAupbDfxWw', // CNN (24/7 live)
            ],
            [
                'city' => 'Washington DC',
                'region' => 'Americas',
                'channel_id' => 'UCupvZG-5ko_eiXAupbDfxWw', // CNN
            ],

            // ASIA
            [
                'city' => 'Tokyo',
                'region' => 'Asia',
                'channel_id' => 'UCp7UxMxM5sNfWjqX9Yj2R_w', // ANN News (sering live)
            ],
            [
                'city' => 'Singapore',
                'region' => 'Asia',
                'channel_id' => 'UCXU9Y8T4pLOu1T7GjVxJ2WQ', // CNA
            ],
            [
                'city' => 'Hong Kong',
                'region' => 'Asia',
                'channel_id' => 'UCQjdC2VqN_L3c1Ml4XQd3Jg', // Al Jazeera
            ],

            // MIDDLE EAST
            [
                'city' => 'Dubai',
                'region' => 'Middle East',
                'channel_id' => 'UCQjdC2VqN_L3c1Ml4XQd3Jg', // Al Jazeera
            ],

            // SPACE
            [
                'city' => 'ISS Live',
                'region' => 'Space',
                'channel_id' => 'UCRuCgmzhczsm89jzPtN2Wuw', // NASA
            ],

        ];

        return collect($channels)
            ->map(function ($channel) {
                $video = $this->searchYoutubeLive($channel['channel_id']);

                // Log untuk debug
                Log::info('Channel: ' . $channel['city'] . ' - Video found: ' . ($video ? 'YES' : 'NO'));

                return [
                    'city' => $channel['city'],
                    'region' => $channel['region'],
                    'title' => $video ? $video['title'] : 'Offline',
                    'video_id' => $video ? $video['videoId'] : null,
                    'thumbnail' => $video ? $video['thumbnail'] : null,
                    'status' => $video ? $video['status'] : 'offline',
                ];
            })
            ->values()
            ->toArray();
    }


    protected function searchYoutubeLive(string $channelId): ?array
    {
        $response = Http::get(
            'https://www.googleapis.com/youtube/v3/search',
            [
                'key' => env('YOUTUBE_API_KEY'),
                'channelId' => $channelId,
                'part' => 'snippet',
                'eventType' => 'live',
                'type' => 'video',
                'maxResults' => 1,
            ]
        );

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
    protected function categorizeGeneralNews(array $news): array
    {
        return [
            'live' => [],        // TODO: isi nanti
            'markets' => [],      // TODO: isi nanti
        ];
    }
}
