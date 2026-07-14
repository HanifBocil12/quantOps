<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\NewsService;

class news extends Controller
{
    //
    protected function getNews() {
        $news = (new NewsService) -> getNews(limit: 20);
        return response() -> json($news);
    }
}
