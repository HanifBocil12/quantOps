<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use danog\MadelineProto\API;
use danog\MadelineProto\Settings;
use danog\MadelineProto\Settings\Connection;
use danog\MadelineProto\Logger;

class TelegramFetchNews extends Command
{
    protected $signature = 'telegram:fetch-news';
    protected $description = 'Fetch latest messages from subscribed Telegram channels via MadelineProto';

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

    public function handle(): int
    {
        $settings = new Settings;
        $settings->getLogger()->setLevel(Logger::LEVEL_WARNING);

        // --- Proxy config (Webshare SOCKS5) ---
        $proxyHost = config('services.telegram_proxy.host');
        $proxyPort = config('services.telegram_proxy.port');
        $proxyUser = config('services.telegram_proxy.user');
        $proxyPass = config('services.telegram_proxy.pass');

        if ($proxyHost && $proxyPort) {
            $connection = new Connection;
            $connection->setProxies([
                [
                    'proxy' => \danog\MadelineProto\Connection::SOCKS5_PROXY,
                    'extra' => [
                        'address'  => $proxyHost,
                        'port'     => (int) $proxyPort,
                        'username' => $proxyUser,
                        'password' => $proxyPass,
                    ],
                ],
            ]);
            $settings->setConnection($connection);
        }
        // --- End proxy config ---

        $MadelineProto = new API(base_path('session.madeline'), $settings);
        $MadelineProto->start();

        $allNews = [];
        $debug = [];

        foreach ($this->channels as $channel) {
            try {
                $result = $MadelineProto->messages->getHistory([
                    'peer'        => "@{$channel}",
                    'offset_id'   => 0,
                    'offset_date' => 0,
                    'add_offset'  => 0,
                    'limit'       => 20,
                    'max_id'      => 0,
                    'min_id'      => 0,
                    'hash'        => 0,
                ]);

                $rawCount = count($result['messages'] ?? []);
                $withText = 0;

                foreach ($result['messages'] as $msg) {
                    if (empty($msg['message'])) continue;
                    $withText++;

                    $allNews[] = [
                        'source'    => $channel,
                        'title'     => Str::limit($msg['message'], 120),
                        'text'      => $msg['message'],
                        'url'       => "https://t.me/{$channel}/{$msg['id']}",
                        'published' => $msg['date'],
                    ];
                }

                $debug[$channel] = "OK: {$rawCount} raw, {$withText} with text";
            } catch (\Throwable $e) {
                $debug[$channel] = "ERROR: " . $e->getMessage();
                continue;
            }
        }

        usort($allNews, fn($a, $b) => $b['published'] - $a['published']);

        Cache::put('telegram_news', $allNews, now()->addMinutes(10));
        Cache::put('telegram_news_debug', $debug, now()->addMinutes(10));

        $this->info('Fetched ' . count($allNews) . ' messages, cached for 10 minutes.');

        return self::SUCCESS;
    }
}
