<?php
// app/Services/BinanceService.php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class BinanceService
{
    protected string $apiKey;
    protected string $apiSecret;
    protected string $baseUrl;
    protected string $proxy;

    public function __construct()
    {
        $this->apiKey = config('services.binance.key');
        $this->apiSecret = config('services.binance.secret');
        $this->baseUrl = config('services.binance.base_url');
        $this->proxy = env('BINANCE_PROXY', '');
    }

    private function getHttpClient()
    {
        return Http::withOptions(array_filter([
            'proxy' => $this->proxy ?: null,
        ]));
    }

    public function getAccountBalance()
    {
        $timestamp = $this->getBinanceTimestamp();

        $params = [
            'timestamp' => $timestamp,
            'recvWindow' => 60000,
        ];
        $params['signature'] = $this->sign($params);

        $response = $this->getHttpClient()
            ->withHeaders(['X-MBX-APIKEY' => $this->apiKey])
            ->get("{$this->baseUrl}/api/v3/account", $params);

        return $response->json();
    }

    private function getBinanceTimestamp(): int
    {
        $response = $this->getHttpClient()->get("{$this->baseUrl}/api/v3/time");
        $json = $response->json();

        if (!isset($json['serverTime'])) {
            throw new \Exception('Binance time failed: ' . json_encode($json));
        }

        return (int) $json['serverTime'];
    }

    public function getAllPrices()
    {
        $response = $this->getHttpClient()->get("{$this->baseUrl}/api/v3/ticker/price");
        return collect($response->json())->pluck('price', 'symbol');
    }

    public function getMarketList(): array
    {
        $response = $this->getHttpClient()
            ->get("{$this->baseUrl}/api/v3/ticker/24hr");

        return collect($response->json())
            ->filter(fn($t) => str_ends_with($t['symbol'], 'USDT'))
            ->map(fn($t) => [
                'symbol'       => str_replace('USDT', '', $t['symbol']),
                'pair'         => $t['symbol'],
                'price'        => (float) $t['lastPrice'],
                'change_pct'   => (float) $t['priceChangePercent'],
                'volume_usdt'  => (float) $t['quoteVolume'],
                'high'         => (float) $t['highPrice'],
                'low'          => (float) $t['lowPrice'],
            ])
            ->filter(fn($m) => $m['price'] > 0 && $m['volume_usdt'] > 0)
            ->sortByDesc('volume_usdt')
            ->values()
            ->toArray();
    }

    public function getPortfolio(): array
    {
        $account = $this->getAccountBalance();

        if (!isset($account['balances'])) {
            return [
                'error' => $account['msg'] ?? 'Gagal ambil data akun',
                'holdings' => [],
                'total_usdt' => 0,
            ];
        }

        $prices = $this->getAllPrices();

        $holdings = collect($account['balances'])
            ->map(function ($b) {
                return [
                    'asset' => $b['asset'],
                    'free' => (float) $b['free'],
                    'locked' => (float) $b['locked'],
                    'total' => (float) $b['free'] + (float) $b['locked'],
                ];
            })
            ->filter(fn($b) => $b['total'] > 0)
            ->map(function ($b) use ($prices) {
                $b['price_usdt'] = $this->resolvePrice($b['asset'], $prices);
                $b['value_usdt'] = $b['total'] * $b['price_usdt'];
                return $b;
            })
            ->sortByDesc('value_usdt')
            ->values();

        return [
            'error' => null,
            'holdings' => $holdings,
            'total_usdt' => $holdings->sum('value_usdt'),
        ];
    }

    private function resolvePrice(string $asset, $prices): float
    {
        if ($asset === 'USDT') return 1.0;

        if (isset($prices[$asset . 'USDT'])) {
            return (float) $prices[$asset . 'USDT'];
        }

        if (isset($prices[$asset . 'BTC']) && isset($prices['BTCUSDT'])) {
            return (float) $prices[$asset . 'BTC'] * (float) $prices['BTCUSDT'];
        }

        return 0.0;
    }

    private function sign(array $params): string
    {
        $query = http_build_query($params);
        return hash_hmac('sha256', $query, $this->apiSecret);
    }
}
