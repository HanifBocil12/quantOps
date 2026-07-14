<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\newsService;

class news extends Controller
{
    //
    protected function getNews() {
        $news = (new newsService) -> getNews(limit: 20);
        return response() -> json($news);
    }
}
