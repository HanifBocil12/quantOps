<?php

namespace App\Http\Controllers;

use App\Services\BinanceService;
use Illuminate\Http\Request;

class pageContoller extends Controller
{
    public function __construct(protected BinanceService $binance) {}

    //
    public function dashboard()
    {
        return view('page.dashboard');
    }
    public function news()
    {
        return view('page.news');
    }
    public function execution()
    {
        return view('page.execution');
    }
    public function market()
    {
        $markets = $this->binance->getMarketList();
        return view('page.market', compact('markets'));
    }
    public function model()
    {
        return view('page.model');
    }
    public function laporan()
    {
        return view('page.laporan');
    }
    public function login()
    {
        return view('page.login');
    }
    public function signup()
    {
        return view('page.signup');
    }
    public function welcome()
    {
        return view('welcome');
    }
}
