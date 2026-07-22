<?php

namespace App\Http\Controllers;

use App\Services\NewsService;

class NewsController extends Controller
{
    public function __construct(protected NewsService $newsService) {}

    public function getNews()
    {
        return response()->json($this->newsService->getNews(limit: 20));
    }
    
}