<?php

use App\Http\Controllers\BinanceController;
use App\Http\Controllers\pageContoller;
use Illuminate\Support\Facades\Route;

Route::get('/', [pageContoller::class, 'welcome'])->name('welcome');
Route::get('/dashboard', [pageContoller::class, 'dashboard'])->name('dashboard');
Route::get('/news', [pageContoller::class, 'news'])->name('news');
Route::get('/market', [pageContoller::class, 'market'])->name('market');
Route::get('/model', [pageContoller::class, 'model'])->name('model');
Route::get('/execution', [pageContoller::class, 'execution'])->name('execution');
Route::get('/laporan', [pageContoller::class, 'laporan'])->name('laporan');

// routes/web.php
Route::get('/portfolio', [BinanceController::class, 'portfolio']);