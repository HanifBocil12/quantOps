<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class NewsService
{
    protected array $rssFeeds = [
        // kosong dulu — isi kalau nanti mau tambah RSS resmi (CoinDesk, dll)
        // format: 'NamaSource' => 'https://url-rss-lengkap.com/feed', m
    ];

    public function getNews(int $limit = 20): array
    {
        $allNews = array_merge(
            $this->getRssNews(),
            Cache::get('telegram_news', [])
        );

        $allNews = $this->filterNews($allNews);

        usort($allNews, fn($a, $b) => $b['published'] - $a['published']);

        return array_slice($allNews, 0, $limit);
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
}
