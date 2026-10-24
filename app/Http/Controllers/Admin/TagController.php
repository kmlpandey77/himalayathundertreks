<?php

namespace App\Http\Controllers\Admin;

use App\Tag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $tags = Tag::paginate(15);
        return view('admin.tag.index', compact('tags'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.tag.create');
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
            'title' => 'required|unique:tags',
            ]);

        $tag = new Tag;
        $tag->title = $request->title;
        // $tag->slug = \Illuminate\Support\Str::slug($request->title);
        $tag->status = $request->status?:0;
        $tag->save();

        if($request->save){
            return redirect()->route('tags.edit', $tag->id)->with('success', 'Tag added.');
        }
        return redirect()->route('tags.index')->with('success', 'Tag added.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function show(Tag $tag)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function edit(Tag $tag)
    {
        return view('admin.tag.edit', compact('tag'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tag $tag)
    {
        $this->validate($request, [
            'title' => 'required|unique:tags,title,' . $tag->id,
            ]);

        $tag->title = $request->title;
        // $tag->slug = \Illuminate\Support\Str::slug($request->title);
        $tag->status = $request->status?:0;
        $tag->save();

        if($request->save){
            return redirect()->route('tags.edit', $tag->id)->with('success', 'Tag saved.');
        }

        return redirect()->route('tags.index')->with('success', 'Tag saved.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tag $tag)
    {
        if($tag && $tag->delete()){
            return redirect()->route('tags.index')->with('success', 'Tag deleted.');
        }else{
            return redirect()->route('tags.index')->with('error', 'Error while deleting Tag.');
        }
    }

    public function showhide(Tag $tag)
    {
        if($tag->status){
            $tag->status = 0;
        }else{
            $tag->status = 1;
        }
        $tag->save();
        return redirect()->route('tags.index')->with('success', 'Status Updated.');
    }
}
