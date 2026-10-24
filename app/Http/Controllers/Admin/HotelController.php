<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\City;
use App\Hotel;

class HotelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $hotels = Hotel::all();
        return view('admin.hotel.index',compact('hotels'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cities = City::all();
        return view('admin.hotel.create',compact('cities'));
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
            'city_id' => 'required',
            'name' => 'required'
        ]);

        $data = array(
            'city_id' => $request->city_id,
            'name' => $request->name,
            'slug' => \Illuminate\Support\Str::slug($request->name,'-'),
            'price' => $request->price,
            'rating' => $request->rate,
            'details' => $request->details,
        );

        if($hotel = Hotel::create($data))
        {
            if($request->hasFile('image'))
            {
                $image_name = $hotel->slug.'-'.$hotel->id.'.'.$request->image->extension();
                $path = $request->image->move('uploads/hotel/', $image_name);
                $hotel->image = $image_name;
                $hotel->save();
            }
        }
        return redirect()->route('hotels.index')->with('success','Hotel Added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Hotel $hotel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Hotel $hotel)
    {
        $cities = City::all();
        return view('admin.hotel.edit',compact('hotel','cities'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Hotel $hotel)
    {
        $this->validate($request, [
            'city_id' => 'required',
            'name' => 'required'
        ]);

        $data = array(
            'city_id' => $request->city_id,
            'name' => $request->name,
            'slug' => \Illuminate\Support\Str::slug($request->name,'-'),
            'price' => $request->price,
            'rating' => $request->rate,
            'details' => $request->details,
        );

        Hotel::where('id',$hotel->id)->update($data);

        if($request->hasFile('image'))
        {
            if($hotel->image && file_exists($image_path = public_path('uploads/hotel/' . $hotel->image))){
                unlink($image_path);
            }

            $image_name = $hotel->slug.'-'.$hotel->id.'.'.$request->image->extension();
            $path = $request->image->move('uploads/hotel/', $image_name);
            $hotel->image = $image_name;
            $hotel->save();
        }
        return redirect()->route('hotels.index')->with('success','Hotel Saved');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Hotel $hotel)
    {
        if($hotel){

            if($hotel->image){
                $image = public_path('uploads/hotel/' . $hotel->image);
                if(file_exists($image)){
                    unlink($image);
                }
            }

            if($hotel->delete()){
                return redirect()->route('hotels.index')->with('success', 'hotel deleted.');
            }else{
                return redirect()->route('hotels.index')->with('error', 'Error while deleting hotel.');
            }

        }else{
            abort();
        }
    }
}
