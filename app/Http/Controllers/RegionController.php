<?php

namespace App\Http\Controllers;

use App\Region;

use Illuminate\Http\Request;

class RegionController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data['region'] = $region = Region::where('slug',$request->path())->first();
        if($region->image && file_exists(public_path('uploads/activity/'.$region->image))){
            $data['image'] = asset('uploads/activity/'.$region->image);
        }else{
            $data['image'] = asset('images/slide01.jpg');
        } 
        return view('region', $data);
    }
}
