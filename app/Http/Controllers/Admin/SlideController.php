<?php

namespace App\Http\Controllers\Admin;

use App\Slide;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SlideController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $slides = Slide::where('in_home', '1')->where('package_id', 0)->where('activity_id', 0)->orderBy('order_by')->paginate(10);
        return view('admin.slide.index', compact('slides'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.slide.create');
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
            'image' => 'required',
            ]);

        $slide = new Slide;
        $slide->package_id = 0;
        $slide->title = $request->title;
        $slide->details = $request->details;
        $slide->link = $request->link;
        $slide->in_home = '1';
        $slide->status = $request->status?:0;
        $slide->save();

        if ($request->hasFile('image')) {
            $image_name = \Illuminate\Support\Str::slug($request->title) . '-'.$slide->id . '.'.$request->image->extension();
            $path = $request->image->move('uploads/slide/', $image_name);
            $slide->image = $image_name;
            $slide->save();
            // $slide->imageCompress($path, 'slide', 'slide');
        }

        return redirect()->route('slides.index')->with('success', 'Slide added.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Slide  $slide
     * @return \Illuminate\Http\Response
     */
    public function show(Slide $slide)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Slide  $slide
     * @return \Illuminate\Http\Response
     */
    public function edit(Slide $slide)
    {
        return view('admin.slide.edit', compact('slide'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Slide  $slide
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Slide $slide)
    {
        $this->validate($request, [
            'title' => 'required',
            ]);

        $slide->title = $request->title;
        $slide->details = $request->details;
        $slide->link = $request->link;
        $slide->status = $request->status?:0;
        $slide->save();

        if ($request->hasFile('image')) {
            if($slide->image && file_exists(public_path('uploads/slide/'.$slide->image))){
                unlink(public_path('uploads/slide/'.$slide->image));
            }
            $image_name = \Illuminate\Support\Str::slug($request->title) . '-'.$slide->id . '.'.$request->image->extension();
            $path = $request->image->move('uploads/slide/', $image_name);
            $slide->image = $image_name;
            $slide->save();
            // $slide->imageCompress($path, 'slide', 'slide');
        }

        return redirect()->route('slides.index')->with('success', 'Slide saved.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Slide  $slide
     * @return \Illuminate\Http\Response
     */
    public function destroy(Slide $slide)
    {
        if($slide){

            if($slide->image){
                $image = public_path('uploads/slide/' . $slide->image);
                if(file_exists($image)){
                    unlink($image);
                }
            }

            if($slide->delete()){
                return redirect()->route('slides.index')->with('success', 'Slide deleted.');
            }else{
                return redirect()->route('slides.index')->with('error', 'Error while deleting Slide.');
            }

        }else{
            abort();
        }

    }

    public function order(Request $request)
    {
        foreach ($request->data as $odr => $id) {
            if($id){
                $odr = $odr + 1;
                $slide = Slide::find($id);
                $slide->order_by = $odr;
                $slide->save();
            }
        }
    }

    public function showhide(Slide $slide)
    {
        if($slide->status){
            $slide->status = 0;
        }else{
            $slide->status = 1;
        }
        $slide->save();
        return redirect()->route('slides.index')->with('success', 'Status Update.');
    }
}
