<?php

namespace App\Http\Controllers\Admin;

use App\News;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $news = News::paginate(10);
        return view('admin.news.index', compact('news'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.news.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|unique:news',            
            'details' => 'required',
        ]);

        $slug = $request->slug? $request->slug : $request->title;
        $slug = $slug == '/'? $slug : \Illuminate\Support\Str::slug($slug);

        $news = new News;
        $news->title = $request->title;
        $news->event_date = $request->event_date;
        $news->slug = $slug;
        $news->details = $request->details;
        $news->save();

        if ($request->hasFile('image')) {
            $image_name = $news->slug . '-'.$news->id . '.'.$request->image->extension();
            $path = $request->image->move('uploads/news/', $image_name);
            $news->image = $image_name;
            $news->save();
            $news->imageCompress($path, 'news');
            $news->imageThumb($path, 'news');
        }

        return redirect()->route('news.index')->with('success', 'News added.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\News  $news
     * @return \Illuminate\Http\Response
     */
    public function show(News $news)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\News  $news
     * @return \Illuminate\Http\Response
     */
    public function edit(News $news)
    {
        return view('admin.news.edit', compact('news'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\News  $news
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, News $news)
    {
        $this->validate($request, [
            'title' => 'required|unique:news,title,' . $news->id,
            'details' => 'required',
        ]);

        $slug = $request->slug? $request->slug : $request->title;
        $slug = $slug == '/'? $slug : \Illuminate\Support\Str::slug($slug);

        $news->title = $request->title;
        $news->event_date = $request->event_date;
        $news->slug = $slug;
        $news->details = $request->details;
        $news->save();

        if ($request->hasFile('image')) {
            $image_name = $news->slug . '-'.$news->id . '.'.$request->image->extension();
            $path = $request->image->move('uploads/news/', $image_name);
            $news->image = $image_name;
            $news->save();
            $news->imageCompress($path, 'news');
            $news->imageThumb($path, 'news');
        }
        return redirect()->route('news.index')->with('success', 'News saved.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\News  $news
     * @return \Illuminate\Http\Response
     */
    public function destroy(News $news)
    {
        if($news){

            if($news->image){
                $image = public_path('uploads/news/' . $news->image);
                if(file_exists($image)){
                    unlink($image);
                }
            }

            if($news->delete()){
                return redirect()->route('news.index')->with('success', 'News deleted.');
            }else{
                return redirect()->route('news.index')->with('error', 'Error while deleting News.');
            }

        }else{
            abort();
        }
    }
}
