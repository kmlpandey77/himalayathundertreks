<?php

namespace App\Http\Controllers\Admin;

use App\Activity;
use App\Destination;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $activities = Activity::all();
        return view('admin.activity.index', compact('activities'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $destinations = Destination::all();
        return view('admin.activity.create', compact('destinations'));
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
            'destination_id' => 'required',
            'title' => 'required|unique:activities',
            'details' => 'required',
        ]);

        $slug = $request->slug? $request->slug : $request->title;
        $slug = $slug == '/'? $slug : \Illuminate\Support\Str::slug($slug);

        $show_in_menu = 0;
        if($request->show_in_menu){
            $show_in_menu = 1;
        }

        $activity = new Activity;
        $activity->destination_id = $request->destination_id;
        $activity->title = $request->title;
        $activity->slug = $slug;
        $activity->details = $request->details;
        $activity->show_in_menu = $show_in_menu;
        $activity->menu_title = $request->menu_title;
        $activity->meta_title = $request->meta_title;
        $activity->meta_keyword = $request->meta_keyword;
        $activity->meta_description = $request->meta_description;
        $activity->status = $request->status?:0;
        $activity->save();

        if ($request->hasFile('image')) {
            $image_name = $activity->slug . '-'.$activity->id . '.'.$request->image->extension();
            $path = $request->image->move('uploads/activities/', $image_name);
            $activity->image = $image_name;
            $activity->save();
            $activity->imageCompress($path, 'activities', 'activities_thumb');
        }

        return redirect()->route('activities.index')->with('success', 'Activity added.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function show(Activity $activity)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function edit(Activity $activity)
    {
        $destinations = Destination::all();
        return view('admin.activity.edit', compact('activity', 'destinations'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Activity $activity)
    {
        $this->validate($request, [
            'destination_id' => 'required',
            'title' => 'required|unique:activities,title,' . $activity->id,
            'details' => 'required',
        ]);

        $slug = $request->slug? $request->slug : $request->title;
        $slug = $slug == '/'? $slug : \Illuminate\Support\Str::slug($slug);

        $show_in_menu = 0;
        if($request->show_in_menu){
            $show_in_menu = 1;
        }

        $activity->destination_id = $request->destination_id;
        $activity->title = $request->title;
        $activity->slug = $slug;
        $activity->details = $request->details;
        $activity->show_in_menu = $show_in_menu;
        $activity->menu_title = $request->menu_title;
        $activity->meta_title = $request->meta_title;
        $activity->meta_keyword = $request->meta_keyword;
        $activity->meta_description = $request->meta_description;
        $activity->status = $request->status?:0;
        $activity->save();

        if ($request->hasFile('image')) {
            if($activity->image && file_exists(public_path('uploads/activities/'.$activity->image))){
                unlink(public_path('uploads/activities/'.$activity->image));
            }
            $image_name = $activity->slug . '-'.$activity->id . '.'.$request->image->extension();
            $path = $request->image->move('uploads/activities/', $image_name);
            $activity->image = $image_name;
            $activity->save();
            $activity->imageCompress($path, 'activities', 'activities_thumb');
        }

        return redirect()->route('activities.index')->with('success', 'Activity saved.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function destroy(Activity $activity)
    {
        if($activity){

            if($activity->image){
                $image = public_path('uploads/activities/' . $activity->image);
                if(file_exists($image)){
                    unlink($image);
                }
            }

            if($activity->delete()){
                return redirect()->route('activities.index')->with('success', 'activity deleted.');
            }else{
                return redirect()->route('activities.index')->with('error', 'Error while deleting activity.');
            }

        }else{
            abort();
        }
    }

    public function showhide(Activity $activity)
    {
        if($activity->status){
            $activity->status = 0;
        }else{
            $activity->status = 1;
        }
        $activity->save();
        return redirect()->route('activities.index')->with('success', 'Status Update.');
    }
}