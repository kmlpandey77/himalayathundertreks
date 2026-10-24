<?php

namespace App\Http\Controllers\Admin;

use App\Blog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $blogs = Blog::paginate(10);
        return view('admin.blog.index', compact('blogs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.blog.create');
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
            'title' => 'required|unique:blogs',
            'details' => 'required',
        ]);

        $slug = $request->slug? $request->slug : $request->title;
        $slug = $slug == '/'? $slug : \Illuminate\Support\Str::slug($slug);

        $blog = new Blog;
        $blog->title = $request->title;
        $blog->event_date = $request->event_date;
        $blog->slug = $slug;
        $blog->details = $request->details;
        $blog->save();

        if ($request->hasFile('image')) {
            $image_name = $blog->slug . '-'.$blog->id . '.'.$request->image->extension();
            $path = $request->image->move('uploads/blogs/', $image_name);
            $blog->image = $image_name;
            $blog->save();
            $blog->imageThumb($path, 'blogs');
            $blog->imageCompress($path, 'blogs');
        }

        return redirect()->route('blogs.index')->with('success', 'Blog added.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function show(Blog $blog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function edit(Blog $blog)
    {
        return view('admin.blog.edit', compact('blog'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Blog $blog)
    {
        $this->validate($request, [
            'title' => 'required|unique:blogs,title,' . $blog->id,
            'details' => 'required',
        ]);

        $slug = $request->slug? $request->slug : $request->title;
        $slug = $slug == '/'? $slug : \Illuminate\Support\Str::slug($slug);

        $blog->title = $request->title;
        $blog->event_date = $request->event_date;
        $blog->slug = $slug;
        $blog->details = $request->details;
        $blog->save();

        if ($request->hasFile('image')) {
            $image_name = $blog->slug . '-'.$blog->id . '.'.$request->image->extension();
            $path = $request->image->move('uploads/blogs/', $image_name);
            $blog->image = $image_name;
            $blog->save();
            $blog->imageThumb($path, 'blogs');
            $blog->imageCompress($path, 'blogs');
        }
        return redirect()->route('blogs.index')->with('success', 'Blog saved.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function destroy(Blog $blog)
    {
        if($blog){

            if($blog->image){
                $image = public_path('uploads/blogs/' . $blog->image);
                if(file_exists($image)){
                    unlink($image);
                }
            }

            if($blog->delete()){
                return redirect()->route('blogs.index')->with('success', 'Blog deleted.');
            }else{
                return redirect()->route('blogs.index')->with('error', 'Error while deleting Blog.');
            }

        }else{
            abort();
        }
    }
}
