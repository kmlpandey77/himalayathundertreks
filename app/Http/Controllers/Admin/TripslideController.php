<?php

namespace App\Http\Controllers\Admin;

use App\Slide;
use App\Package;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TripslideController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($trip)
    {
        $trip = Package::find($trip);
        $slides = Slide::where('package_id', $trip->id)->get();
        return view('admin.tripslide.index', compact('slides', 'trip'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($trip)
    {
        return view('admin.tripslide.create', compact('trip'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $trip)
    {
        $previous = explode('?', url()->previous());

        $this->validate($request, [
            'title' => 'required',
            'image' => 'required',
        ]);
        $in_home = '0';
        if($request->in_home){
            $in_home = '1';
        }

        $slide = new Slide;
        $slide->package_id = $trip;
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

        return redirect()->route('tripslides.index', [$trip, isset($previous[1]) ? $previous[1] : null])->with('success', 'Slide added.');
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
        $trip = $slide->package_id;
        return view('admin.tripslide.edit', compact('slide','trip'));
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
        $previous = explode('?', url()->previous());

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
        }

        return redirect()->route('tripslides.index', [$slide->package_id, isset($previous[1]) ? $previous[1] : null])->with('success', 'Slide saved.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Slide  $slide
     * @return \Illuminate\Http\Response
     */
    public function destroy(Slide $slide)
    {
        $trip = $slide->package_id;

        if($slide){
            if($slide->image){
                $image = public_path('uploads/slide/' . $slide->image);
                if(file_exists($image)){
                    unlink($image);
                }
            }

            if($slide->delete()){
                return redirect()->route('tripslides.index', $trip)->with('success', 'Slide deleted.');
            }else{
                return redirect()->route('tripslides.index', $trip)->with('error', 'Error while deleting Slide.');
            }

        }else{
            abort();
        }

    }
}
