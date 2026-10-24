<?php

namespace App\Http\Controllers\Admin;

use App\Region;
use App\Activity;
use App\Destination;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RegionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $regions = Region::orderBy('order_by')->paginate(10);
        return view('admin.region.index', compact('regions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $destinations = Destination::all();
        return view('admin.region.create', compact('destinations'));
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
            'activity_id' => 'required',
            'title' => 'required|unique:regions',            
            'details' => 'required',
        ]);

        $slug = $request->slug? $request->slug : $request->title;
        $slug = $slug == '/'? $slug : \Illuminate\Support\Str::slug($slug);

        $region = new Region;
        $region->activity_id = $request->activity_id;
        $region->title = $request->title;
        $region->slug = $slug;
        $region->details = $request->details;
        $region->meta_title = $request->meta_title;
        $region->meta_keyword = $request->meta_keyword;
        $region->meta_description = $request->meta_description;
        $region->status = $request->status?:0;
        $region->save();

        if ($request->hasFile('image')) {
            $image_name = $region->slug . '-'.$region->id . '.'.$request->image->extension();
            $path = $request->image->move('uploads/region/', $image_name);
            $region->image = $image_name;
            $region->save();
            $region->imageCompress($path, 'region', 'trip_thumb');
        }

        return redirect()->route('regions.index')->with('success', 'Region added.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Region  $region
     * @return \Illuminate\Http\Response
     */
    public function show(Region $region)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Region  $region
     * @return \Illuminate\Http\Response
     */
    public function edit(Region $region)
    {
        $destinations = Destination::all();        
        return view('admin.region.edit', compact('region', 'destinations'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Region  $region
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Region $region)
    {
        $this->validate($request, [
            'activity_id' => 'required',            
            'title' => 'required|unique:regions,title,' . $region->id,
            'details' => 'required',
        ]);

        $slug = $request->slug? $request->slug : $request->title;
        $slug = $slug == '/'? $slug : \Illuminate\Support\Str::slug($slug);

        $region->activity_id = $request->activity_id;
        $region->title = $request->title;
        $region->slug = $slug;
        $region->details = $request->details;
        $region->meta_title = $request->meta_title;
        $region->meta_keyword = $request->meta_keyword;
        $region->meta_description = $request->meta_description;
        $region->status = $request->status?:0;
        $region->save();

        if ($request->hasFile('image')) {
            if($region->image && file_exists(public_path('uploads/region/'.$region->image))){
                unlink(public_path('uploads/region/'.$region->image));
            }
            $image_name = $region->slug . '-'.$region->id . '.'.$request->image->extension();
            $path = $request->image->move('uploads/region/', $image_name);
            $region->image = $image_name;
            $region->save();
            $region->imageCompress($path, 'region', 'trip_thumb');
        }

        return redirect()->route('regions.index')->with('success', 'Region saved.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Region  $region
     * @return \Illuminate\Http\Response
     */
    public function destroy(Region $region)
    {
        if($region){

            if($region->image){
                $image = public_path('uploads/region/' . $region->image);
                if(file_exists($image)){
                    unlink($image);
                }
            }

            if($region->delete()){
                return redirect()->route('regions.index')->with('success', 'Region deleted.');
            }else{
                return redirect()->route('regions.index')->with('error', 'Error while deleting Region.');
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
                $region = Region::find($id);
                $region->order_by = $odr;
                $region->save();
            }
        }
    }

    public function showhide(Region $region)
    {
        if($region->status){
            $region->status = 0;
        }else{
            $region->status = 1;
        }
        $region->save();
        return redirect()->route('regions.index')->with('success', 'Status Update.');        
    }
}