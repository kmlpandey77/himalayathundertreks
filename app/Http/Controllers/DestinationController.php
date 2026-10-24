<?php

namespace App\Http\Controllers;

use App\Destination;

use Illuminate\Http\Request;

class DestinationController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data['destination'] = $destination = Destination::where('slug',$request->path())->first();
        if($destination->image && file_exists(public_path('uploads/destination/'.$destination->image))){
            $data['image'] = asset('uploads/destination/'.$destination->image);
        }else{
            $data['image'] = asset('images/slide01.jpg');
        }

        return view('destination', $data);
    }
}
