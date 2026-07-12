<?php
// app/Services/BinanceService.php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class BinanceService
{
    protected string $apiKey;
    protected string $apiSecret;
    protected string $baseUrl;

    public function __construct()
    {
        $this->apiKey = config('services.binance.key');
        $this->apiSecret = config('services.binance.secret');
        $this->baseUrl = config('services.binance.base_url');
    }

    public function getAccountBalance()
    {
        $params = [
            'timestamp' => now()->getTimestampMs(),
            'recvWindow' => 5000,
        ];
        $params['signature'] = $this->sign($params);

        $response = Http::withHeaders([
            'X-MBX-APIKEY' => $this->apiKey,
        ])->get("{$this->baseUrl}/api/v3/account", $params);

        return $response->json();
    }

    public function getAllPrices()
    {
        // Semua harga sekaligus, dipake buat itung value tiap koin
        $response = Http::get("{$this->baseUrl}/api/v3/ticker/price");

        return collect($response->json())->pluck('price', 'symbol');
    }

    /**
     * Gabungin balance + harga jadi portfolio siap pakai
     */
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
            ->filter(fn ($b) => $b['total'] > 0) // buang koin kosong
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
        if ($asset === 'USDT') {
            return 1.0;
        }

        // coba ASSETUSDT dulu, kalo gaada coba ASSETBUSD/ASSETBTC*harga BTC
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