<?php

use App\Http\Controllers\BinanceController;
use App\Http\Controllers\NewsController;
use Illuminate\Support\Facades\Route;


Route::prefix('binance')->group(function () {

    Route::get('/dashboard', [BinanceController::class, 'portfolio'])
        ->name('api.binance.dashboard');

    Route::get('/market', [BinanceController::class, 'market'])
        ->name('api.binance.market');
});


Route::prefix('news')->group(function () {

    Route::get('/', [NewsController::class, 'getNews'])
        ->name('news.index');

    Route::get('/crypto', [NewsController::class, 'getCryptoNews'])
        ->name('news.crypto');

    Route::get('/world-news', [NewsController::class, 'getWorldNews'])
        ->name('news.world');

    Route::get('/getLiveWebcams', [NewsController::class, 'getLiveWebcams'])
        ->name('news.webcams');

    Route::get('/war', [NewsController::class, 'getWarNews'])
        ->name('news.war');

    Route::get('/watchlist', [BinanceController::class, 'watchlist'])
        ->name('markets.watchlist');

    // ============ COINGECKO ============

    Route::get('/coingecko/global', [NewsController::class, 'getCoinGeckoGlobal'])
        ->name('news.coingecko.global');

    Route::get('/coingecko/trending', [NewsController::class, 'getCoinGeckoTrending'])
        ->name('news.coingecko.trending');

    // ============ DEFILLAMA ============

    Route::get('/defillama/chains', [NewsController::class, 'getDefiLlamaChains'])
        ->name('news.defillama.chains');

    Route::get('/defillama/protocols', [NewsController::class, 'getDefiLlamaProtocols'])
        ->name('news.defillama.protocols');

    // ============ DERIBIT ============

    Route::get('/deribit/index', [NewsController::class, 'getDeribitIndex'])
        ->name('news.deribit.index');

    Route::get('/deribit/options', [NewsController::class, 'getDeribitOptions'])
        ->name('news.deribit.options');

    // ============ ETHERSCAN ============

    Route::get('/etherscan/gas', [NewsController::class, 'getEtherscanGas'])
        ->name('news.etherscan.gas');

    Route::get('/etherscan/eth-price', [NewsController::class, 'getEtherscanEthPrice'])
        ->name('news.etherscan.eth-price');

    // ============ COINGLASS ============

    Route::get('/coinglass/funding', [NewsController::class, 'getCoinglassFunding'])
        ->name('news.coinglass.funding');

    Route::get('/coinglass/open-interest', [NewsController::class, 'getCoinglassOpenInterest'])
        ->name('news.coinglass.open-interest');

    // ============ ALCHEMY ============

    Route::get('/alchemy/block', [NewsController::class, 'getAlchemyBlock'])
        ->name('news.alchemy.block');

    Route::get('/alchemy/gas', [NewsController::class, 'getAlchemyGas'])
        ->name('news.alchemy.gas');

    // ============ CRYPTOQUANT ============

    Route::get('/cryptoquant/netflow', [NewsController::class, 'getCryptoQuantNetflow'])
        ->name('news.cryptoquant.netflow');

    // ============ MARKET STATS SUMMARY & FUNDING RATES ============

    Route::get('/market-stats-summary', [NewsController::class, 'getMarketStatsSummary'])
        ->name('news.market-stats-summary');

    Route::get('/markets/funding-rates', [NewsController::class, 'getMarketsFundingRates'])
        ->name('news.markets.funding-rates');

    // ============ MACRO ============

    Route::get('/macro/government', [NewsController::class, 'getGovernmentNews'])
        ->name('news.macro.government');

    Route::get('/macro/trump', [NewsController::class, 'getTrumpNews'])
        ->name('news.macro.trump');

    Route::get('/macro/fed', [NewsController::class, 'getFedLive'])
        ->name('news.macro.fed');

    Route::get('/macro/markets', [NewsController::class, 'getMacroMarkets'])
        ->name('news.macro.markets');


    // ============ COMMODITY ============

    Route::get('/commodity', [NewsController::class, 'getCommodityNews'])
        ->name('news.commodity');


    // ============ ONCHAIN DETAIL ============

    Route::get('/onchain/summary', [NewsController::class, 'getOnchainSummary'])
        ->name('news.onchain.summary');
});
