<?php
// app/Http/Controllers/BinanceController.php

namespace App\Http\Controllers;

use App\Services\BinanceService;

class BinanceController extends Controller
{
    public function __construct(protected BinanceService $binance) {}

    public function portfolio()
    {
        $data = $this->binance->getPortfolio();

        return view('page.f', $data);
    }
}