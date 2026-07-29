<?php

namespace App\Http\Controllers;

use App\Services\NewsService;

class NewsController extends Controller
{
    public function __construct(
        protected NewsService $newsService
    ) {}

    // ============ GENERAL / WORLD / WAR ============

    public function getNews()
    {
        return response()->json(
            $this->newsService->getNews(limit: 20)
        );
    }

    public function getCryptoNews()
    {
        return response()->json(
            $this->newsService->getCryptoNewsGrouped(limitPerGroup: 10)
        );
    }

    public function getLiveWebcams()
    {
        return response()->json(
            $this->newsService->getLiveWebcams()
        );
    }

    public function getWarNews()
    {
        return response()->json(
            $this->newsService->getWarNews(limit: 10)
        );
    }

    public function getWorldNews()
    {
        return response()->json(
            $this->newsService->getWorldNews(limit: 20)
        );
    }

    // ============ COINGECKO ============

    public function getCoinGeckoGlobal()
    {
        return response()->json(
            $this->newsService->getCoinGeckoGlobal()
        );
    }

    public function getCoinGeckoTrending()
    {
        return response()->json(
            $this->newsService->getCoinGeckoTrending()
        );
    }

    // ============ DEFILLAMA ============

    public function getDefiLlamaChains()
    {
        return response()->json(
            $this->newsService->getDefiLlamaChainsTvl(limit: 10)
        );
    }

    public function getDefiLlamaProtocols()
    {
        return response()->json(
            $this->newsService->getDefiLlamaTopProtocols(limit: 10)
        );
    }

    // ============ DERIBIT ============

    public function getDeribitIndex()
    {
        return response()->json(
            $this->newsService->getDeribitIndexPrices()
        );
    }

    public function getDeribitOptions()
    {
        return response()->json(
            $this->newsService->getDeribitOptionsSummary()
        );
    }

    // ============ ETHERSCAN ============

    public function getEtherscanGas()
    {
        return response()->json(
            $this->newsService->getEtherscanGasOracle()
        );
    }

    public function getEtherscanEthPrice()
    {
        return response()->json(
            $this->newsService->getEtherscanEthPrice()
        );
    }

    // ============ COINGLASS ============

    public function getCoinglassFunding()
    {
        return response()->json(
            $this->newsService->getCoinglassFundingRates()
        );
    }

    public function getCoinglassOpenInterest()
    {
        return response()->json(
            $this->newsService->getCoinglassOpenInterest()
        );
    }

    // ============ ALCHEMY ============

    public function getAlchemyBlock()
    {
        return response()->json(
            $this->newsService->getAlchemyLatestBlock()
        );
    }

    public function getAlchemyGas()
    {
        return response()->json(
            $this->newsService->getAlchemyGasPrice()
        );
    }

    // ============ CRYPTOQUANT ============

    public function getCryptoQuantNetflow()
    {
        return response()->json(
            $this->newsService->getCryptoQuantExchangeNetflow()
        );
    }

    // ============ MARKET STATS SUMMARY & FUNDING RATES ============

    public function getMarketStatsSummary()
    {
        return response()->json(
            $this->newsService->getMarketStatsSummary()
        );
    }

    public function getMarketsFundingRates()
    {
        return response()->json(
            $this->newsService->getFundingRatesForSymbols(['BTC', 'ETH', 'BNB'])
        );
    }
}