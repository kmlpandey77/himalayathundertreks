<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Blog;
use App\Page;

class BlogController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data['page'] = $page = Page::where('slug',$request->path())->first();
        $data['blogs'] = Blog::orderby('event_date', 'desc')->orderby('created_at', 'desc')->paginate(18);
        return view('blog.index', $data);
    }

    public function view(Blog $blog, $slug)
    {
        if(!$blog->slug == $slug) abort(404);
        $blog = Blog::where('slug',$slug)->first();
        $other_blogs = Blog::where('id','<>',$blog->id)->orderby('event_date', 'desc')->limit(10)->orderby('event_date', 'desc')->get();
        return view('blog.view', compact('blog','other_blogs'));
    }

    
}
