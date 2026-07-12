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
}
