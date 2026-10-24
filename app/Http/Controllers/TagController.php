<?php

namespace App\Http\Controllers;

use App\Tag;

use Illuminate\Http\Request;

class TagController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $tag = Tag::where('slug',$request->path())->first();
        return view('tag', compact('tag'));
    }
}
