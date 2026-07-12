<?php

use App\Http\Controllers\BinanceController;
use Illuminate\Support\Facades\Route;

Route::prefix('binance')->group(function () {
    Route::get('/dashboard', [BinanceController::class, 'portfolio']);
});