<?php

namespace App\Http\Controllers;

use App\Services\BinanceService;
use Illuminate\Http\JsonResponse;

class BinanceController extends Controller
{
    public function __construct(protected BinanceService $binance) {}

    public function portfolio(): JsonResponse
    {
        return response()->json($this->binance->getPortfolio());
    }


    public function market(): JsonResponse
    {
        return response()->json($this->binance->getMarketList());
    }

    public static function formatPrice(float $price): string
    {
        if ($price >= 1)      return number_format($price, 2);
        if ($price >= 0.01)   return number_format($price, 4);
        if ($price >= 0.0001) return number_format($price, 6);
        return number_format($price, 8);
    }
}
