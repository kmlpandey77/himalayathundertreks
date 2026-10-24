<?php

namespace App\Http\Controllers;

use App\Activity;

use Illuminate\Http\Request;

class ActivityController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data['activity'] = $activity = Activity::where('slug',$request->path())->first();
        if($activity->image && file_exists(public_path('uploads/activity/'.$activity->image))){
            $data['image'] = asset('uploads/activity/'.$activity->image);
        }else{
            $data['image'] = asset('images/slide01.jpg');
        }
        return view('activity', $data);
    }
}
