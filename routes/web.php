<?php

use App\Http\Controllers\BinanceController;
use App\Http\Controllers\pageContoller;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;


Route::get('/', [pageContoller::class, 'welcome'])->name('welcome');
Route::get('/dashboard', [pageContoller::class, 'dashboard'])->name('dashboard');
Route::get('/news', [pageContoller::class, 'news'])->name('news');
Route::get('/market', [pageContoller::class, 'market'])->name('market');
Route::get('/model', [pageContoller::class, 'model'])->name('model');
Route::get('/execution', [pageContoller::class, 'execution'])->name('execution');
Route::get('/laporan', [pageContoller::class, 'laporan'])->name('laporan');

Route::get('/debug/proxy', function () {
    return response()->json([
        'proxy' => env('BINANCE_PROXY'),
        'base_url' => env('BINANCE_BASE_URL'),
    ]);
});