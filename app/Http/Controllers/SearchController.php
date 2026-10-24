<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Package;
use App\Activity;
use App\Destination;
use DB;

class SearchController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = DB::table('packages')
                    ->select(
                        'packages.id',
                        'packages.title',
                        'packages.image'
                    );

        if(isset($request->activity) && $request->activity){
            $query->where('packages.category_id', $request->activity);
        }elseif(isset($request->destination) && $request->destination){
            $query->join('activities', 'activities.id', '=', 'packages.category_id')
                ->join('destinations', 'destinations.id', '=', 'activities.destination_id')
                ->where('destinations.id', $request->destination);
        }

        if(isset($request->duration) && $request->duration){
            if($request->duration == 1){
                $query->where('packages.duration',1);
            }elseif($request->duration == 5){
                $query->where('packages.duration', '>', 21);
            }else{
                $query->whereBetween('packages.duration', config('duration.between.' . $request->duration));
            }            
        }       
        $destination = Destination::where('id',$request->destination)->get();
        $activity = Activity::where('id',$request->activity)->get();
        $packages = $query->where('packages.status', 1)->paginate(9);
        return view('search', compact('packages','destination','activity'));
    }

    public function searchcategory(Request $request)
    {
        $activities = Activity::where('destination_id', $request->destination)->get();
        return view('searchcategory', compact('activities'));     
    }
}
