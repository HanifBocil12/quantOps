<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

/**
 * Class newsService
 * @package App\Services
 */
class NewsService
{
    protected array $feeds  = [
        'BitcoinMag'    => 'https://rsshub.app/telegram/channel/BitcoinMagazineTelegram'
    ];

    public function getNews(int $limit = 20): array
    {
        $allNews = [];

        foreach ($this->feeds as $source => $url) {
            try {
                $response = Http::timeout(5)->get($url);

                if ($response->failed()) continue;

                $xml = simplexml_load_string($response->body());

                if (!$xml) continue;

                foreach ($xml->channel->item as $item) {
                    $allNews[] = [
                        'source'    => $source,
                        'title'     => (string) $item->title,
                        'url'       => (string) $item->link,
                        'published' => strtotime((string) $item->pubDate),
                    ];
                }
            } catch (\Exception $e) {
                continue;
            }
        }

        usort($allNews, fn($a, $b) => $b['published'] - $a['published']);

        return array_slice($allNews, 0, $limit);
    }
}
