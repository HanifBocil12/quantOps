<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Symfony\Component\DomCrawler\Crawler;

class TelegramFetchNews extends Command
{
    protected $signature = 'telegram:fetch-news';
    protected $description = 'Fetch latest messages from public Telegram channels via t.me/s/ scraping';

    protected array $channels = [
        'BitcoinMagazineTelegram',
        'Cointelegraph',
        'Glassnode',
        'coingeckonews',
        'cryptoquant_official',
        'whale_alert_io',
        'wublockchainenglish',
        'intothecryptoverse_news',
    ];

    protected array $channelsWorld = [
        'ReutersWorld',
        'BBCWorld',
        'bloomberg',
        'AJEnglish',
        'dwnews',
        'guardian',
    ];

    public function handle(): int
    {
        $cryptoNews = [];
        $worldNews = [];
        $debug = [];

        $this->fetchChannels($this->channels, $cryptoNews, $debug);
        $this->fetchChannels($this->channelsWorld, $worldNews, $debug);

        usort($cryptoNews, fn($a, $b) => $b['published'] - $a['published']);
        usort($worldNews, fn($a, $b) => $b['published'] - $a['published']);

        Cache::put('telegram_news', $cryptoNews, now()->addMinutes(10));
        Cache::put('telegram_world_news', $worldNews, now()->addMinutes(10));
        Cache::put('telegram_news_debug', $debug, now()->addMinutes(10));

        $this->info(
            'Crypto: ' . count($cryptoNews) .
                ' | World: ' . count($worldNews)
        );

        return self::SUCCESS;
    }

    protected function fetchChannels(array $channels, array &$news, array &$debug): void
    {
        foreach ($channels as $channel) {
            try {
                $response = Http::withHeaders([
                    'User-Agent' => 'Mozilla/5.0 (compatible; QuantOpsBot/1.0)',
                ])
                    ->timeout(10)
                    ->get("https://t.me/s/{$channel}");

                if (!$response->successful()) {
                    $debug[$channel] = "ERROR: HTTP {$response->status()}";
                    continue;
                }

                $crawler = new Crawler($response->body());
                $nodes = $crawler->filter('div.tgme_widget_message');

                $rawCount = $nodes->count();
                $withText = 0;

                $nodes->each(function (Crawler $node) use (&$news, &$withText, $channel) {
                    $textNode = $node->filter('.tgme_widget_message_text');

                    if ($textNode->count() === 0) {
                        return;
                    }

                    $text = $this->extractText($textNode);
                    $text = $this->stripSponsoredTail($text);

                    if ($text === '') {
                        return;
                    }

                    $withText++;

                    $postAttr = $node->attr('data-post');
                    $msgId = $postAttr ? Str::afterLast($postAttr, '/') : null;

                    $dateNode = $node->filter('time');

                    $datetime = $dateNode->count()
                        ? strtotime($dateNode->attr('datetime'))
                        : time();

                    $news[] = [
                        'source'    => $channel,
                        'title'     => Str::limit($text, 120),
                        'text'      => $text,
                        'url'       => $msgId
                            ? "https://t.me/{$channel}/{$msgId}"
                            : "https://t.me/s/{$channel}",
                        'published' => $datetime,
                    ];
                });

                $debug[$channel] = "OK: {$rawCount} raw, {$withText} with text";
            } catch (\Throwable $e) {
                $debug[$channel] = "ERROR: " . $e->getMessage();

                Log::error("Telegram scrape failed for {$channel}: " . $e->getMessage());
            }
        }
    }

    protected function extractText(Crawler $textNode): string
    {
        $html = $textNode->html();

        $html = preg_replace('/<br\b[^>]*>/i', "\n", $html);
        $html = preg_replace('/<[^>]+>/', ' ', $html);

        $text = html_entity_decode($html, ENT_QUOTES, 'UTF-8');
        $text = preg_replace('/[ \t\x{00A0}]+/u', ' ', $text);
        $text = preg_replace('/ *\n */', "\n", $text);
        $text = preg_replace('/\n{3,}/', "\n\n", $text);
        $text = preg_replace('/([a-z0-9])\.([A-Z])/', '$1. $2', $text);

        return trim($text);
    }

    protected function stripSponsoredTail(string $text): string
    {
        return trim(
            preg_replace('/\s*Sponsored by .+?(—|-)\s*link\s*$/iu', '', $text)
        );
    }
}
