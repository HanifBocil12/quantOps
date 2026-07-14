<?php

use App\Http\Controllers\BinanceController;
use App\Http\Controllers\news;
use Illuminate\Support\Facades\Route;

Route::prefix('binance')->group(function () {
    Route::get('/dashboard', [BinanceController::class, 'portfolio']);
});

Route::prefix('news')->group(function(){
    Route::get('/news', [news::class, 'getNews']);
});