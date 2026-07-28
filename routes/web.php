<?php

use App\Http\Controllers\BinanceController;
use App\Http\Controllers\pageContoller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;


Route::get('/', [pageContoller::class, 'welcome'])->name('welcome');
Route::get('/dashboard', [pageContoller::class, 'dashboard'])->name('dashboard');
Route::get('/news', [pageContoller::class, 'news'])->name('news');
Route::get('/market', [pageContoller::class, 'market'])->name('market');
Route::get('/model', [pageContoller::class, 'model'])->name('model');
Route::get('/execution', [pageContoller::class, 'execution'])->name('execution');
Route::get('/laporan', [pageContoller::class, 'laporan'])->name('laporan');
Route::get('/trade/{pair}', [pageContoller::class, 'trade'])->name('trade');

Route::get('/cron/run-schedule', function () {
    if (request()->query('secret') !== config('services.cron.cron_secret')) {
        abort(403);
    }

    Artisan::call('schedule:run');

    return response()->json(['status' => 'ok', 'output' => Artisan::output()]);
});

Route::get('/cron/check-cache', function () {
    if (request()->query('secret') !== config('services.cron.cron_secret')) {
        abort(403);
    }
    return response()->json([
        'telegram_news' => \Illuminate\Support\Facades\Cache::get('telegram_news', 'EMPTY_OR_NOT_SET'),
    ]);
});
