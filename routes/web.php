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
    $response = \Illuminate\Support\Facades\Http::withOptions([
        'proxy' => 'http://fdegllhw:rw80pg9ykfjr@64.137.96.74:6641',
    ])->get('https://api.binance.com/api/v3/time');

    return response()->json([
        'status' => $response->status(),
        'body'   => $response->json(),
    ]);
});
