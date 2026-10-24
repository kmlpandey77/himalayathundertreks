<?php

namespace App\Http\Controllers;

use App\News;

use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::orderby('created_at', 'desc')->paginate();
        return view('news.index', compact('news'));
    }

    public function view($slug)
    {
        $news = News::where('slug',$slug)->first();
        $other_news = News::where('id','<>',$news->id)->orderby('created_at', 'desc')->limit(10)->get();
        return view('news.view', compact('news','other_news'));
    }
}
