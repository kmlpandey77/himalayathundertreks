<?php

namespace App\Http\Controllers\Admin;

use App\Social;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SocialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $socials = Social::all();
        return view('admin.social.index', compact('socials'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $jsonString = file_get_contents(base_path('public/icons.json'));

        $data = json_decode($jsonString, true);
        return view('admin.social.create',compact('data'));
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
            'title' => 'required',            
            'icon' => 'required',            
            'link' => 'required',
        ]);

        $social = new Social;
        $social->title = $request->title;
        $social->class = $request->class;
        $social->icon = $request->icon;
        $social->link = $request->link;
        $social->save();

        if ($request->hasFile('image')) {
            $image_name = 'social-'.$social->id . '.'.$request->image->extension();
            $path = $request->image->move('uploads/socials/', $image_name);
            $social->image = $image_name;
            $social->save();
        }

        return redirect()->route('socials.index')->with('success', 'Social added.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Social  $social
     * @return \Illuminate\Http\Response
     */
    public function show(Social $social)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Social  $social
     * @return \Illuminate\Http\Response
     */
    public function edit(Social $social)
    {
        $jsonString = file_get_contents(base_path('public/icons.json'));

        $data = json_decode($jsonString, true);
        return view('admin.social.edit', compact('social','data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Social  $social
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Social $social)
    {
        $this->validate($request, [
            'title' => 'required',            
            'icon' => 'required',            
            'link' => 'required',
        ]);

        $social->title = $request->title;
        $social->class = $request->class;
        $social->icon = $request->icon;
        $social->link = $request->link;
        $social->save();

        if ($request->hasFile('image')) {
            $image_name = 'social-'.$social->id . '.'.$request->image->extension();
            $path = $request->image->move('uploads/socials/', $image_name);
            $social->image = $image_name;
            $social->save();
        }
        return redirect()->route('socials.index')->with('success', 'Social saved.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Social  $social
     * @return \Illuminate\Http\Response
     */
    public function destroy(Social $social)
    {
        if($social){

            if($social->image){
                $image = public_path('uploads/socials/' . $social->image);
                if(file_exists($image)){
                    unlink($image);
                }
            }

            if($social->delete()){
                return redirect()->route('socials.index')->with('success', 'Social deleted.');
            }else{
                return redirect()->route('socials.index')->with('error', 'Error while deleting Social.');
            }

        }else{
            abort();
        }
    }
}
