<?php

namespace App\Http\Controllers\Admin;

use App\Video;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $videos = Video::all();
        return view('admin.video.index', compact('videos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.video.create');
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
            'title' => 'required|unique:videos',
            'link' => 'required',
        ]);

        $video = new Video;
        $video->title = $request->title;
        $video->link = $request->link;
        $video->save();

        return redirect()->route('videos.index')->with('success', 'Video added.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function show(Video $video)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function edit(Video $video)
    {
        return view('admin.video.edit', compact('video'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Video $video)
    {
        $this->validate($request, [
            'title' => 'required|unique:videos,title,' . $video->id,
            'link' => 'required',
        ]);

        $video->title = $request->title;
        $video->link = $request->link;
        $video->save();

        return redirect()->route('videos.index')->with('success', 'Video saved.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function destroy(Video $video)
    {
        if($video){

            if($video->image){
                $image = public_path('uploads/videos/' . $video->image);
                if(file_exists($image)){
                    unlink($image);
                }
            }

            if($video->delete()){
                return redirect()->route('videos.index')->with('success', 'Video deleted.');
            }else{
                return redirect()->route('videos.index')->with('error', 'Error while deleting Video.');
            }

        }else{
            abort();
        }
    }
}
