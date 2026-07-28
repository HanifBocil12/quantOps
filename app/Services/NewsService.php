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
        // Definisikan multiple channel per kota
        $cityChannels = [

            // EUROPE
            'London' => [
                'region' => 'Europe',
                'channels' => [
                    'UC9Ad5PzjArHpf3P2rwFNcVg', // Sky News
                    'UCupvZG-5ko_eiXAupbDfxWw', // CNN
                    'UCX6OQ3DkcsbYNE6H8uQQuVA', // Euronews
                    'UCBi2mrWuNuyYy4gbM6fU18Q', // ABC News
                ]
            ],
            'Frankfurt' => [
                'region' => 'Europe',
                'channels' => [
                    'UCX6OQ3DkcsbYNE6H8uQQuVA', // Euronews
                    'UCupvZG-5ko_eiXAupbDfxWw', // CNN
                    'UCknLrEdhRCp1aegoMqRaCZg', // DW News
                ]
            ],
            'Berlin' => [
                'region' => 'Europe',
                'channels' => [
                    'UCX6OQ3DkcsbYNE6H8uQQuVA', // Euronews
                    'UCknLrEdhRCp1aegoMqRaCZg', // DW News
                    'UCupvZG-5ko_eiXAupbDfxWw', // CNN
                ]
            ],

            // AMERICAS
            'New York' => [
                'region' => 'Americas',
                'channels' => [
                    'UCupvZG-5ko_eiXAupbDfxWw', // CNN
                    'UCBi2mrWuNuyYy4gbM6fU18Q', // ABC News
                    'UCeY0bbntWzzVIaj2z3QigXg', // NBC News
                    'UC9Ad5PzjArHpf3P2rwFNcVg', // Sky News
                ]
            ],
            'Washington DC' => [
                'region' => 'Americas',
                'channels' => [
                    'UCBi2mrWuNuyYy4gbM6fU18Q', // ABC News
                    'UCeY0bbntWzzVIaj2z3QigXg', // NBC News
                    'UCupvZG-5ko_eiXAupbDfxWw', // CNN
                ]
            ],

            // ASIA
            'Tokyo' => [
                'region' => 'Asia',
                'channels' => [
                    'UCp7UxMxM5sNfWjqX9Yj2R_w', // ANN News
                    'UC19xL2I6UMy8yQ6cP9F9tRg', // NHK World
                    'UCXU9Y8T4pLOu1T7GjVxJ2WQ', // CNA
                ]
            ],
            'Singapore' => [
                'region' => 'Asia',
                'channels' => [
                    'UCXU9Y8T4pLOu1T7GjVxJ2WQ', // CNA
                    'UCp7UxMxM5sNfWjqX9Yj2R_w', // ANN News
                    'UCQjdC2VqN_L3c1Ml4XQd3Jg', // Al Jazeera
                ]
            ],
            'Hong Kong' => [
                'region' => 'Asia',
                'channels' => [
                    'UCQjdC2VqN_L3c1Ml4XQd3Jg', // Al Jazeera
                    'UCXU9Y8T4pLOu1T7GjVxJ2WQ', // CNA
                    'UCp7UxMxM5sNfWjqX9Yj2R_w', // ANN News
                ]
            ],

            // MIDDLE EAST
            'Dubai' => [
                'region' => 'Middle East',
                'channels' => [
                    'UCQjdC2VqN_L3c1Ml4XQd3Jg', // Al Jazeera
                    'UCX6OQ3DkcsbYNE6H8uQQuVA', // Euronews
                    'UCupvZG-5ko_eiXAupbDfxWw', // CNN
                ]
            ],

            // SPACE
            'ISS Live' => [
                'region' => 'Space',
                'channels' => [
                    'UCRuCgmzhczsm89jzPtN2Wuw', // NASA
                    'UCRuCgmzhczsm89jzPtN2Wuw', // NASA (cuma 1)
                ]
            ],

        ];

        $result = [];

        foreach ($cityChannels as $city => $config) {
            $video = null;

            // Coba semua channel untuk kota ini
            foreach ($config['channels'] as $channelId) {
                $video = $this->searchYoutubeLive($channelId);

                if ($video) {
                    logger('Found live for ' . $city . ' from channel: ' . $channelId);
                    break; // Berhenti kalo udah ketemu
                }
            }

            $result[] = [
                'city' => $city,
                'region' => $config['region'],
                'title' => $video ? $video['title'] : 'Offline',
                'video_id' => $video ? $video['videoId'] : null,
                'thumbnail' => $video ? $video['thumbnail'] : null,
                'status' => $video ? $video['status'] : 'offline',
            ];
        }

        return $result;
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
