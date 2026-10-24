<?php

namespace App\Http\Controllers\Admin;

use App\Slide;
use App\Region;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RegionslideController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($region)
    {
        $region = Region::find($region);
        $slides = Slide::where('region_id', $region->id)->paginate(10);
        return view('admin.regionslide.index', compact('slides', 'region'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($region)
    {
        return view('admin.regionslide.create', compact('region'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $region)
    {
        // dd($request);
        $this->validate($request, [
            'title' => 'required',
            'image' => 'required',
        ]);
        $in_home = '0';
        if($request->in_home){
            $in_home = '1';
        }

        $slide = new Slide;
        $slide->package_id = 0;
        $slide->region_id = $region;
        $slide->title = $request->title;
        $slide->details = $request->details;
        $slide->in_home = $in_home;
        $slide->save();

        if ($request->hasFile('image')) {
            $image_name = \Illuminate\Support\Str::slug($request->title) . '-'.$slide->id . '.'.$request->image->extension();
            $path = $request->image->move('uploads/slide/', $image_name);
            $slide->image = $image_name;
            $slide->save();
            $slide->imageCompress($path, 'slide', 'trip_slide');
        }

        return redirect()->route('regionslides.index', $region)->with('success', 'Slide added.');
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
        $region = $slide->region_id;
        return view('admin.regionslide.edit', compact('slide', 'region'));
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

        $in_home = '0';
        if($request->in_home){
            $in_home = '1';
        }

        $slide->title = $request->title;
        $slide->details = $request->details;
        $slide->in_home = $in_home;
        $slide->save();

        if ($request->hasFile('image')) {
            if($slide->image && file_exists(public_path('uploads/slide/'.$slide->image))){
                unlink(public_path('uploads/slide/'.$slide->image));
            }
            $image_name = \Illuminate\Support\Str::slug($request->title) . '-'.$slide->id . '.'.$request->image->extension();
            $path = $request->image->move('uploads/slide/', $image_name);
            $slide->image = $image_name;
            $slide->save();
            $slide->imageCompress($path, 'slide', 'trip_slide');
        }

        return redirect()->route('regionslides.index', $slide->region_id)->with('success', 'Slide saved.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Slide  $slide
     * @return \Illuminate\Http\Response
     */
    public function destroy(Slide $slide)
    {
        $region = $slide->region_id;
        
        if($slide){
            if($slide->image){
                $image = public_path('uploads/slide/' . $slide->image);
                if(file_exists($image)){
                    unlink($image);
                }
            }

            if($slide->delete()){
                return redirect()->route('regionslides.index', $region)->with('success', 'Slide deleted.');
            }else{
                return redirect()->route('regionslides.index', $region)->with('error', 'Error while deleting Slide.');
            }

        }else{
            abort();
        }
        
    }
}
