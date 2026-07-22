<?php

use App\Http\Controllers\BinanceController;
use App\Http\Controllers\NewsController;
use Illuminate\Support\Facades\Route;

Route::prefix('binance')->group(function () {
    Route::get('/dashboard', [BinanceController::class, 'portfolio'])->name('api.binance.dashboard');
    Route::get('/market', [BinanceController::class, 'market'])->name('api.binance.market');
});

Route::prefix('news')->group(function () {
    Route::get('/', [NewsController::class, 'getNews'])->name('news.index');
});
