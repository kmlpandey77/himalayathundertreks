<?php

namespace App\Http\Controllers\Admin;

use App\Associate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AssociateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $associates = Associate::paginate(10);
        return view('admin.associate.index', compact('associates'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.associate.create');
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
            'link' => 'required',
        ]);

        $associate = new Associate;
        $associate->title = $request->title;
        $associate->slug = \Illuminate\Support\Str::slug($request->title);
        $associate->link = $request->link;
        $associate->save();

        if ($request->hasFile('image')) {
            $image_name = 'social-'.$associate->id . '.'.$request->image->extension();
            $path = $request->image->move('uploads/associates/', $image_name);
            $associate->image = $image_name;
            $associate->save();
        }

        return redirect()->route('associates.index')->with('success', 'Associate added.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Associate  $associate
     * @return \Illuminate\Http\Response
     */
    public function show(Associate $associate)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Associate  $associate
     * @return \Illuminate\Http\Response
     */
    public function edit(Associate $associate)
    {
        return view('admin.associate.edit', compact('associate'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Associate  $associate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Associate $associate)
    {
        $this->validate($request, [
            'title' => 'required',
            'link' => 'required',
        ]);

        $associate->title = $request->title;
        $associate->slug = \Illuminate\Support\Str::slug($request->title);
        $associate->link = $request->link;
        $associate->save();

        if ($request->hasFile('image')) {
            $image_name = 'social-'.$associate->id . '.'.$request->image->extension();
            $path = $request->image->move('uploads/associates/', $image_name);
            $associate->image = $image_name;
            $associate->save();
        }
        return redirect()->route('associates.index')->with('success', 'Associate saved.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Associate  $associate
     * @return \Illuminate\Http\Response
     */
    public function destroy(Associate $associate)
    {
        if($associate){

            if($associate->image){
                $image = public_path('uploads/associates/' . $associate->image);
                if(file_exists($image)){
                    unlink($image);
                }
            }

            if($associate->delete()){
                return redirect()->route('associates.index')->with('success', 'Associate deleted.');
            }else{
                return redirect()->route('associates.index')->with('error', 'Error while deleting Associate.');
            }

        }else{
            abort();
        }
    }
}
