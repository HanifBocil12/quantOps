<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class NewsService
{
    protected array $rssFeeds = [

        'world' => [
            'Reuters World' =>
            'https://www.reutersagency.com/feed/?best-topics=world&post_type=best',

            'BBC World' =>
            'https://feeds.bbci.co.uk/news/world/rss.xml',

            'Al Jazeera' =>
            'https://www.aljazeera.com/xml/rss/all.xml',
        ],

        'crypto' => [
            'CoinDesk' =>
            'https://www.coindesk.com/arc/outboundfeeds/rss/',

            'Cointelegraph' =>
            'https://cointelegraph.com/rss',

            'Bitcoin Magazine' =>
            'https://bitcoinmagazine.com/.rss/full/',
        ],

        'ai' => [
            'OpenAI' =>
            'https://openai.com/news/rss.xml',

            'Google AI' =>
            'https://blog.google/technology/ai/rss/',

            'Hugging Face' =>
            'https://huggingface.co/blog/feed.xml',
        ],

        'science' => [
            'NASA' =>
            'https://www.nasa.gov/rss/dyn/breaking_news.rss',
        ],

        'economy' => [
            'CNBC Economy' =>
            'https://www.cnbc.com/id/20910258/device/rss/rss.html',
        ],

    ];

    protected array $warRssFeeds = [

        'Reuters Conflict' =>
        'https://www.reutersagency.com/feed/?best-topics=conflict-and-terrorism&post_type=best',

        'BBC World War' =>
        'https://feeds.bbci.co.uk/news/world/rss.xml',

        'Al Jazeera War' =>
        'https://www.aljazeera.com/xml/rss/all.xml',

        'AP News World' =>
        'https://feeds.apnews.com/rss/apf-topnews',

        'DW World' =>
        'https://rss.dw.com/rdf/rss-en-world',

        'France24 World' =>
        'https://www.france24.com/en/rss',

        'The Guardian World' =>
        'https://www.theguardian.com/world/rss',

    ];

    protected array $warKeywords = [
        'war',
        'attack',
        'strike',
        'missile',
        'invasion',
        'military',
        'army',
        'troops',
        'conflict',
        'ceasefire',
        'nato',
        'ukraine',
        'russia',
        'iran',
        'israel',
        'gaza',
    ];

    protected array $onchainAlertSources = [
        'whale_alert_io',
    ];

    // ============================================================
    // GENERAL / WORLD / WAR NEWS (RSS + Telegram)
    // ============================================================

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
            $this->getRssNews('crypto'),
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
        $rssNews = $this->filterNews($this->getRssNews('world'));
        $telegramNews = $this->filterNews(Cache::get('telegram_world_news', []));

        usort($rssNews, fn($a, $b) => $b['published'] - $a['published']);
        usort($telegramNews, fn($a, $b) => $b['published'] - $a['published']);

        // Jatah minimal 30% slot buat Telegram, sisanya RSS
        $telegramQuota = (int) ceil($limit * 0.3);
        $rssQuota = $limit - $telegramQuota;

        $combined = array_merge(
            array_slice($telegramNews, 0, $telegramQuota),
            array_slice($rssNews, 0, $rssQuota)
        );

        usort($combined, fn($a, $b) => $b['published'] - $a['published']);

        return array_slice($combined, 0, $limit);
    }

    public function getWarNews(int $limit = 20): array
    {
        $cacheKey = 'rss_news:war';

        $rssNews = Cache::remember($cacheKey, now()->addMinutes(5), function () {
            return $this->fetchRssFeeds($this->warRssFeeds, 'war');
        });

        // Filter cuma yang beneran nyinggung keyword konflik
        $rssNews = array_values(array_filter($rssNews, function ($item) {
            $title = mb_strtolower($item['title']);

            foreach ($this->warKeywords as $keyword) {
                if (str_contains($title, $keyword)) {
                    return true;
                }
            }

            return false;
        }));

        $allNews = array_merge($rssNews, Cache::get('telegram_war_news', []));

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

        $clean = preg_replace('/\s+/', ' ', $clean);

        $clean = preg_replace('/^(bitcoin magazine )?(twitterx )?(just in|new|breaking) ?/', '', $clean);

        return implode(' ', array_slice(explode(' ', $clean), 0, 10));
    }

    /**
     * Fetch RSS, di-cache per topic 5 menit biar gak nge-hit external feed
     * tiap request. Pass $topic = null buat ambil semua topic sekaligus.
     */
    protected function getRssNews(?string $topic = null): array
    {
        $topics = $topic
            ? [$topic => $this->rssFeeds[$topic] ?? []]
            : $this->rssFeeds;

        $allNews = [];

        foreach ($topics as $topicKey => $feeds) {
            $cacheKey = "rss_news:{$topicKey}";

            $topicNews = Cache::remember($cacheKey, now()->addMinutes(5), function () use ($feeds, $topicKey) {
                return $this->fetchRssFeeds($feeds, $topicKey);
            });

            $allNews = array_merge($allNews, $topicNews);
        }

        return $allNews;
    }

    /**
     * Fetch aktual ke RSS feeds pake pool biar paralel, bukan sequential.
     */
    protected function fetchRssFeeds(array $feeds, string $topic): array
    {
        $allNews = [];

        if (empty($feeds)) {
            return $allNews;
        }

        $responses = Http::pool(
            fn($pool) =>
            collect($feeds)->map(
                fn($url, $source) =>
                $pool->as($source)->timeout(5)->get($url)
            )->toArray()
        );

        foreach ($feeds as $source => $url) {
            $response = $responses[$source] ?? null;

            if (!$response || $response instanceof \Throwable || $response->failed()) {
                Log::warning("RSS fetch failed for {$source}");
                continue;
            }

            try {
                $xml = simplexml_load_string($response->body());
                if (!$xml || !isset($xml->channel->item)) continue;

                foreach ($xml->channel->item as $item) {
                    $allNews[] = [
                        'source'    => $source,
                        'topic'     => $topic,
                        'title'     => (string) $item->title,
                        'url'       => (string) $item->link,
                        'published' => strtotime((string) $item->pubDate),
                    ];
                }
            } catch (\Exception $e) {
                Log::warning("RSS parse failed for {$source}: " . $e->getMessage());
                continue;
            }
        }

        return $allNews;
    }

    protected function categorizeGeneralNews(array $news): array
    {
        return [
            'live' => [],        // TODO: isi nanti
            'markets' => [],      // TODO: isi nanti
        ];
    }

    // ============================================================
    // COINGECKO (keyless)
    // ============================================================

    public function getCoinGeckoTrending(): array
    {
        return Cache::remember('coingecko_trending', now()->addMinutes(15), function () {
            try {
                $response = Http::timeout(10)
                    ->get('https://api.coingecko.com/api/v3/search/trending');

                if (!$response->successful()) {
                    Log::warning('CoinGecko trending fetch failed', ['status' => $response->status()]);
                    return [];
                }

                $data = $response->json('coins', []);

                return collect($data)
                    ->map(fn($c) => [
                        'id'         => $c['item']['id'] ?? null,
                        'symbol'     => strtoupper($c['item']['symbol'] ?? ''),
                        'name'       => $c['item']['name'] ?? '',
                        'rank'       => $c['item']['market_cap_rank'] ?? null,
                        'thumb'      => $c['item']['thumb'] ?? null,
                        'price_usd'  => $c['item']['data']['price'] ?? null,
                        'change_24h' => $c['item']['data']['price_change_percentage_24h']['usd'] ?? null,
                    ])
                    ->values()
                    ->toArray();
            } catch (\Exception $e) {
                Log::warning('CoinGecko trending error: ' . $e->getMessage());
                return [];
            }
        });
    }

    public function getCoinGeckoGlobal(): array
    {
        return Cache::remember('coingecko_global', now()->addMinutes(15), function () {
            try {
                $response = Http::timeout(10)
                    ->get('https://api.coingecko.com/api/v3/global');

                if (!$response->successful()) {
                    Log::warning('CoinGecko global fetch failed', ['status' => $response->status()]);
                    return [];
                }

                $data = $response->json('data', []);

                return [
                    'total_market_cap_usd'   => $data['total_market_cap']['usd'] ?? null,
                    'total_volume_usd'       => $data['total_volume']['usd'] ?? null,
                    'btc_dominance'          => $data['market_cap_percentage']['btc'] ?? null,
                    'eth_dominance'          => $data['market_cap_percentage']['eth'] ?? null,
                    'market_cap_change_24h'  => $data['market_cap_change_percentage_24h_usd'] ?? null,
                    'active_cryptocurrencies' => $data['active_cryptocurrencies'] ?? null,
                ];
            } catch (\Exception $e) {
                Log::warning('CoinGecko global error: ' . $e->getMessage());
                return [];
            }
        });
    }

    // ============================================================
    // DEFILLAMA (keyless)
    // ============================================================

    public function getDefiLlamaChainsTvl(int $limit = 10): array
    {
        return Cache::remember('defillama_chains_tvl', now()->addMinutes(15), function () use ($limit) {
            try {
                $response = Http::timeout(10)
                    ->get('https://api.llama.fi/v2/chains');

                if (!$response->successful()) {
                    Log::warning('DefiLlama chains fetch failed', ['status' => $response->status()]);
                    return [];
                }

                return collect($response->json())
                    ->sortByDesc('tvl')
                    ->take($limit)
                    ->map(fn($c) => [
                        'name' => $c['name'] ?? '',
                        'tvl'  => $c['tvl'] ?? 0,
                        'token_symbol' => $c['tokenSymbol'] ?? null,
                    ])
                    ->values()
                    ->toArray();
            } catch (\Exception $e) {
                Log::warning('DefiLlama chains error: ' . $e->getMessage());
                return [];
            }
        });
    }

    public function getDefiLlamaTopProtocols(int $limit = 10): array
    {
        return Cache::remember('defillama_protocols_tvl', now()->addMinutes(15), function () use ($limit) {
            try {
                $response = Http::timeout(10)
                    ->get('https://api.llama.fi/protocols');

                if (!$response->successful()) {
                    Log::warning('DefiLlama protocols fetch failed', ['status' => $response->status()]);
                    return [];
                }

                return collect($response->json())
                    ->sortByDesc('tvl')
                    ->take($limit)
                    ->map(fn($p) => [
                        'name'     => $p['name'] ?? '',
                        'symbol'   => $p['symbol'] ?? null,
                        'chain'    => $p['chain'] ?? null,
                        'category' => $p['category'] ?? null,
                        'tvl'      => $p['tvl'] ?? 0,
                        'change_1d' => $p['change_1d'] ?? null,
                    ])
                    ->values()
                    ->toArray();
            } catch (\Exception $e) {
                Log::warning('DefiLlama protocols error: ' . $e->getMessage());
                return [];
            }
        });
    }

    // ============================================================
    // DERIBIT (keyless, endpoint public)
    // ============================================================

    public function getDeribitIndexPrices(): array
    {
        return Cache::remember('deribit_index_prices', now()->addMinutes(5), function () {
            $indices = ['btc_usd', 'eth_usd'];
            $result = [];

            foreach ($indices as $index) {
                try {
                    $response = Http::timeout(10)
                        ->get('https://www.deribit.com/api/v2/public/get_index_price', [
                            'index_name' => $index,
                        ]);

                    if (!$response->successful()) {
                        Log::warning("Deribit index fetch failed for {$index}", ['status' => $response->status()]);
                        continue;
                    }

                    $data = $response->json('result');

                    if ($data) {
                        $result[] = [
                            'index' => strtoupper($index),
                            'price' => $data['index_price'] ?? null,
                        ];
                    }
                } catch (\Exception $e) {
                    Log::warning("Deribit index error for {$index}: " . $e->getMessage());
                    continue;
                }
            }

            return $result;
        });
    }

    public function getDeribitOptionsSummary(string $currency = 'BTC'): array
    {
        return Cache::remember("deribit_options_summary_{$currency}", now()->addMinutes(10), function () use ($currency) {
            try {
                $response = Http::timeout(10)
                    ->get('https://www.deribit.com/api/v2/public/get_book_summary_by_currency', [
                        'currency' => $currency,
                        'kind' => 'option',
                    ]);

                if (!$response->successful()) {
                    Log::warning('Deribit options summary fetch failed', ['status' => $response->status()]);
                    return [];
                }

                return collect($response->json('result', []))
                    ->sortByDesc('volume')
                    ->take(10)
                    ->map(fn($o) => [
                        'instrument' => $o['instrument_name'] ?? '',
                        'volume'     => $o['volume'] ?? 0,
                        'mark_price' => $o['mark_price'] ?? null,
                        'open_interest' => $o['open_interest'] ?? null,
                    ])
                    ->values()
                    ->toArray();
            } catch (\Exception $e) {
                Log::warning('Deribit options summary error: ' . $e->getMessage());
                return [];
            }
        });
    }

    // ============================================================
    // ETHERSCAN
    // ============================================================

    public function getEtherscanGasOracle(): array
    {
        return Cache::remember('etherscan_gas_oracle', now()->addMinutes(2), function () {
            try {
                $response = Http::timeout(10)->get('https://api.etherscan.io/api', [
                    'module' => 'gastracker',
                    'action' => 'gasoracle',
                    'apikey' => env('ETHERSCAN_API_KEY'),
                ]);

                if (!$response->successful()) {
                    Log::warning('Etherscan gas oracle fetch failed', ['status' => $response->status()]);
                    return [];
                }

                $result = $response->json('result');

                if (!$result) {
                    return [];
                }

                return [
                    'safe_gwei'     => $result['SafeGasPrice'] ?? null,
                    'propose_gwei'  => $result['ProposeGasPrice'] ?? null,
                    'fast_gwei'     => $result['FastGasPrice'] ?? null,
                    'base_fee'      => $result['suggestBaseFee'] ?? null,
                ];
            } catch (\Exception $e) {
                Log::warning('Etherscan gas oracle error: ' . $e->getMessage());
                return [];
            }
        });
    }

    public function getEtherscanEthPrice(): array
    {
        return Cache::remember('etherscan_eth_price', now()->addMinutes(5), function () {
            try {
                $response = Http::timeout(10)->get('https://api.etherscan.io/api', [
                    'module' => 'stats',
                    'action' => 'ethprice',
                    'apikey' => env('ETHERSCAN_API_KEY'),
                ]);

                if (!$response->successful()) {
                    Log::warning('Etherscan eth price fetch failed', ['status' => $response->status()]);
                    return [];
                }

                $result = $response->json('result');

                return [
                    'eth_usd' => $result['ethusd'] ?? null,
                    'eth_btc' => $result['ethbtc'] ?? null,
                ];
            } catch (\Exception $e) {
                Log::warning('Etherscan eth price error: ' . $e->getMessage());
                return [];
            }
        });
    }

    // ============================================================
    // COINGLASS
    // ============================================================

    public function getCoinglassFundingRates(string $symbol = 'BTC'): array
    {
        return Cache::remember("coinglass_funding_rates_{$symbol}", now()->addMinutes(5), function () use ($symbol) {
            try {
                $response = Http::timeout(10)
                    ->withHeaders(['CG-API-KEY' => env('COINGLASS_API_KEY')])
                    ->get('https://open-api-v4.coinglass.com/api/futures/funding-rate/exchange-list', [
                        'symbol' => $symbol,
                    ]);

                if (!$response->successful()) {
                    Log::warning('Coinglass funding rate fetch failed', ['status' => $response->status(), 'symbol' => $symbol]);
                    return [];
                }

                return collect($response->json('data', []))
                    ->take(10)
                    ->map(fn($item) => [
                        'exchange' => $item['exchangeName'] ?? '',
                        'funding_rate' => $item['fundingRate'] ?? null,
                    ])
                    ->values()
                    ->toArray();
            } catch (\Exception $e) {
                Log::warning('Coinglass funding rate error: ' . $e->getMessage());
                return [];
            }
        });
    }

    public function getCoinglassOpenInterest(string $symbol = 'BTC'): array
    {
        return Cache::remember("coinglass_open_interest_{$symbol}", now()->addMinutes(5), function () use ($symbol) {
            try {
                $response = Http::timeout(10)
                    ->withHeaders(['CG-API-KEY' => env('COINGLASS_API_KEY')])
                    ->get('https://open-api-v4.coinglass.com/api/futures/open-interest/exchange-list', [
                        'symbol' => $symbol,
                    ]);

                if (!$response->successful()) {
                    Log::warning('Coinglass open interest fetch failed', ['status' => $response->status(), 'symbol' => $symbol]);
                    return [];
                }

                return collect($response->json('data', []))
                    ->take(10)
                    ->map(fn($item) => [
                        'exchange' => $item['exchangeName'] ?? '',
                        'open_interest_usd' => $item['openInterestUsd'] ?? null,
                    ])
                    ->values()
                    ->toArray();
            } catch (\Exception $e) {
                Log::warning('Coinglass open interest error: ' . $e->getMessage());
                return [];
            }
        });
    }

    /**
     * Rata-rata funding rate lintas exchange buat 1 symbol.
     * Dipake buat badge kecil di Markets watchlist & summary stats.
     */
    public function getAvgFundingRate(string $symbol): ?float
    {
        $rates = $this->getCoinglassFundingRates($symbol);

        if (empty($rates)) {
            return null;
        }

        $values = collect($rates)->pluck('funding_rate')->filter(fn($v) => $v !== null);

        return $values->isEmpty() ? null : round($values->avg(), 6);
    }

    /**
     * Funding rate buat beberapa symbol sekaligus, dipake Markets watchlist.
     */
    public function getFundingRatesForSymbols(array $symbols): array
    {
        return collect($symbols)
            ->mapWithKeys(fn($symbol) => [$symbol => $this->getAvgFundingRate($symbol)])
            ->toArray();
    }

    // ============================================================
    // ALCHEMY (JSON-RPC, bukan REST)
    // ============================================================

    public function getAlchemyWhaleTransactions(float $minEth = 100, int $blockCount = 5): array
    {
        return Cache::remember("alchemy_whale_tx_{$minEth}_{$blockCount}", now()->addMinutes(2), function () use ($minEth, $blockCount) {
            try {
                // 1. Ambil block number terbaru
                $blockNumberResponse = Http::timeout(10)
                    ->post('https://eth-mainnet.g.alchemy.com/v2/' . env('ALCHEMY_API_KEY'), [
                        'jsonrpc' => '2.0',
                        'method'  => 'eth_blockNumber',
                        'params'  => [],
                        'id'      => 1,
                    ]);

                if (!$blockNumberResponse->successful()) {
                    Log::warning('Alchemy whale tx: block number fetch failed');
                    return [];
                }

                $latestBlockDec = hexdec($blockNumberResponse->json('result'));

                if (!$latestBlockDec) {
                    return [];
                }

                $minWei = $minEth * 1e18;
                $allWhaleTxs = [];

                // 2. Loop scan beberapa block terakhir, pakai Http::pool biar paralel
                $blockNumbers = range($latestBlockDec, $latestBlockDec - ($blockCount - 1));

                $responses = Http::pool(function ($pool) use ($blockNumbers) {
                    foreach ($blockNumbers as $bn) {
                        $pool->as((string) $bn)
                            ->timeout(15)
                            ->post('https://eth-mainnet.g.alchemy.com/v2/' . env('ALCHEMY_API_KEY'), [
                                'jsonrpc' => '2.0',
                                'method'  => 'eth_getBlockByNumber',
                                'params'  => ['0x' . dechex($bn), true],
                                'id'      => 1,
                            ]);
                    }
                });

                foreach ($blockNumbers as $bn) {
                    $response = $responses[(string) $bn] ?? null;

                    if (!$response || $response instanceof \Throwable || !$response->successful()) {
                        continue;
                    }

                    $block = $response->json('result');

                    if (!$block || empty($block['transactions'])) {
                        continue;
                    }

                    $whaleTxs = collect($block['transactions'])
                        ->filter(function ($tx) use ($minWei) {
                            $valueWei = hexdec($tx['value'] ?? '0x0');
                            return $valueWei >= $minWei;
                        })
                        ->map(function ($tx) use ($bn) {
                            return [
                                'block_number' => $bn,
                                'hash'  => $tx['hash'] ?? null,
                                'from'  => $tx['from'] ?? null,
                                'to'    => $tx['to'] ?? null,
                                'value_eth' => round(hexdec($tx['value']) / 1e18, 4),
                            ];
                        })
                        ->values()
                        ->toArray();

                    $allWhaleTxs = array_merge($allWhaleTxs, $whaleTxs);
                }

                // Urutkan value terbesar dulu
                usort($allWhaleTxs, fn($a, $b) => $b['value_eth'] <=> $a['value_eth']);

                return [
                    'block_range' => [
                        'from' => min($blockNumbers),
                        'to'   => max($blockNumbers),
                    ],
                    'transactions' => array_slice($allWhaleTxs, 0, 20), // cap 20 biar UI gak kepanjangan
                ];
            } catch (\Exception $e) {
                Log::warning('Alchemy whale tx error: ' . $e->getMessage());
                return [];
            }
        });
    }

    public function getAlchemyLatestBlock(): array
    {
        return Cache::remember('alchemy_latest_block', now()->addMinutes(1), function () {
            try {
                $response = Http::timeout(10)
                    ->post('https://eth-mainnet.g.alchemy.com/v2/' . env('ALCHEMY_API_KEY'), [
                        'jsonrpc' => '2.0',
                        'method'  => 'eth_blockNumber',
                        'params'  => [],
                        'id'      => 1,
                    ]);

                if (!$response->successful()) {
                    Log::warning('Alchemy latest block fetch failed', ['status' => $response->status()]);
                    return [];
                }

                $hex = $response->json('result');

                return [
                    'block_number' => $hex ? hexdec($hex) : null,
                ];
            } catch (\Exception $e) {
                Log::warning('Alchemy latest block error: ' . $e->getMessage());
                return [];
            }
        });
    }

    public function getAlchemyGasPrice(): array
    {
        return Cache::remember('alchemy_gas_price', now()->addMinutes(2), function () {
            try {
                $response = Http::timeout(10)
                    ->post('https://eth-mainnet.g.alchemy.com/v2/' . env('ALCHEMY_API_KEY'), [
                        'jsonrpc' => '2.0',
                        'method'  => 'eth_gasPrice',
                        'params'  => [],
                        'id'      => 1,
                    ]);

                if (!$response->successful()) {
                    Log::warning('Alchemy gas price fetch failed', ['status' => $response->status()]);
                    return [];
                }

                $hex = $response->json('result');

                return [
                    'gas_price_wei' => $hex ? hexdec($hex) : null,
                    'gas_price_gwei' => $hex ? hexdec($hex) / 1e9 : null,
                ];
            } catch (\Exception $e) {
                Log::warning('Alchemy gas price error: ' . $e->getMessage());
                return [];
            }
        });
    }

    // ============================================================
    // CRYPTOQUANT
    // ============================================================

    public function getCryptoQuantExchangeNetflow(string $exchange = 'binance', string $symbol = 'btc'): array
    {
        return Cache::remember("cryptoquant_netflow_{$exchange}_{$symbol}", now()->addMinutes(15), function () use ($exchange, $symbol) {
            try {
                $response = Http::timeout(10)
                    ->withHeaders(['Authorization' => 'Bearer ' . env('CRYPTOQUANT_API_KEY')])
                    ->get("https://api.cryptoquant.com/v1/{$symbol}/exchange-flows/netflow", [
                        'exchange' => $exchange,
                        'window' => 'hour',
                        'limit' => 1,
                    ]);

                if (!$response->successful()) {
                    Log::warning('CryptoQuant netflow fetch failed', ['status' => $response->status()]);
                    return [];
                }

                $latest = $response->json('result.data.0');

                if (!$latest) {
                    return [];
                }

                return [
                    'exchange' => $exchange,
                    'symbol'   => strtoupper($symbol),
                    'netflow'  => $latest['netflow_total'] ?? null,
                    'date'     => $latest['date'] ?? null,
                ];
            } catch (\Exception $e) {
                Log::warning('CryptoQuant netflow error: ' . $e->getMessage());
                return [];
            }
        });
    }

    // ============================================================
    // MARKET STATS SUMMARY (dipake buat row "Market Stats"/Komoditas)
    // ============================================================

    public function getMarketStatsSummary(): array
    {
        return Cache::remember('market_stats_summary', now()->addMinutes(5), function () {
            $gas = $this->getEtherscanGasOracle();
            $index = $this->getDeribitIndexPrices();
            $funding = $this->getCoinglassFundingRates('BTC');
            $global = $this->getCoinGeckoGlobal();

            return [
                'gas' => $gas,
                'index' => $index,
                'funding_avg' => collect($funding)->pluck('funding_rate')->filter()->avg(),
                'global' => $global,
            ];
        });
    }

    // ============================================================
    // YOUTUBE LIVE WEBCAMS
    // ============================================================

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
            env('YOUTUBE_API_KEY_1'),
            env('YOUTUBE_API_KEY_2'),
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
}
