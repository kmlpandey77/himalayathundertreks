<?php

namespace App\Http\Controllers\Admin;

use App\Destination;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DestinationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $destinations = Destination::orderBy('order_by')->get();
        return view('admin.destination.index', compact('destinations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.destination.create');
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
            'title' => 'required|unique:destinations',            
            'details' => 'required',
        ]);

        $slug = $request->slug? $request->slug : $request->title;
        $slug = $slug == '/'? $slug : \Illuminate\Support\Str::slug($slug);

        $destination = new Destination;
        $destination->title = $request->title;
        $destination->slug = $slug;
        $destination->details = $request->details;
        $destination->meta_title = $request->meta_title;
        $destination->meta_keyword = $request->meta_keyword;
        $destination->meta_description = $request->meta_description;
        $destination->order_by = (Destination::max('order_by') + 1);
        $destination->save();

        if ($request->hasFile('image')) {
            $image_name = $destination->slug . '-'.$destination->id . '.'.$request->image->extension();
            $path = $request->image->move('uploads/destination/', $image_name);
            $destination->image = $image_name;
            $destination->save();
            $destination->imageCompress($path, 'destination', 'trip_slide');
        }

        return redirect()->route('destinations.index')->with('success', 'Destination added.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Destination  $destination
     * @return \Illuminate\Http\Response
     */
    public function show(Destination $destination)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Destination  $destination
     * @return \Illuminate\Http\Response
     */
    public function edit(Destination $destination)
    {
        return view('admin.destination.edit', compact('destination'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Destination  $destination
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Destination $destination)
    {
        $this->validate($request, [
            'title' => 'required|unique:destinations,title,' . $destination->id,            
            'details' => 'required',
        ]);

        $slug = $request->slug? $request->slug : $request->title;
        $slug = $slug == '/'? $slug : \Illuminate\Support\Str::slug($slug);

        $destination->title = $request->title;
        $destination->slug = $slug;
        $destination->details = $request->details;
        $destination->meta_title = $request->meta_title;
        $destination->meta_keyword = $request->meta_keyword;
        $destination->meta_description = $request->meta_description;
        $destination->save();

        if ($request->hasFile('image')) {
            if($destination->image && file_exists(public_path('uploads/destination/'.$destination->image))){
                unlink(public_path('uploads/destination/'.$destination->image));
            }
            $image_name = $destination->slug . '-'.$destination->id . '.'.$request->image->extension();
            $path = $request->image->move('uploads/destination/', $image_name);
            $destination->image = $image_name;
            $destination->save();
            $destination->imageCompress($path, 'destination', 'trip_slide');
        }

        return redirect()->route('destinations.index')->with('success', 'Destination saved.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Destination  $destination
     * @return \Illuminate\Http\Response
     */
    public function destroy(Destination $destination)
    {
        if($destination){

            if($destination->image){
                $image = public_path('uploads/destination/' . $destination->image);
                if(file_exists($image)){
                    unlink($image);
                }
            }

            if($destination->delete()){
                return redirect()->route('destinations.index')->with('success', 'Destination deleted.');
            }else{
                return redirect()->route('destinations.index')->with('error', 'Error while deleting Destination.');
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
                $dest = Destination::find($id);
                $dest->order_by = $odr;
                $dest->save();
            }
        }
    }

    public function showhide(Destination $dest)
    {
        if($dest->status){
            $dest->status = 0;
        }else{
            $dest->status = 1;
        }
        $dest->save();
        return redirect()->route('regions.index')->with('success', 'Status Update.');        
    }
}
