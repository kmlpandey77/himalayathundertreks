<?php

namespace App\Http\Controllers\Admin;

use App\Team;
use App\Teamcategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $categories = Teamcategory::all();
        if(isset($request->category)){
            if($request->category == 0){
                return redirect()->route('teams.index');
            }
            $teams = Team::where('teamcategory_id', $request->category)->orderBy('order_by')->paginate(10);            
        }
        else
        {
            $teams = Team::orderBy('teamcategory_id')->orderBy('order_by')->paginate(10);
        }        
        return view('admin.team.index', compact('teams', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Teamcategory::all();
        return view('admin.team.create', compact('categories'));
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
            'teamcategory_id' => 'required',            
            'name' => 'required',            
            'position' => 'required',
            'details' => 'required',
        ]);

        $team = new Team;
        $team->teamcategory_id = $request->teamcategory_id;
        $team->name = $request->name;
        $team->position = $request->position;
        $team->email = $request->email;
        $team->phone = $request->phone;
        $team->details = $request->details;
        $team->order_by = (Team::where('teamcategory_id', $request->teamcategory_id)->max('order_by') + 1);
        $team->save();

        if ($request->hasFile('image')) {
            $image_name = 'team-'.$team->id . '.'.$request->image->extension();
            $path = $request->image->move('uploads/teams/', $image_name);
            $team->image = $image_name;
            $team->save();
            $team->imageThumb($path, 'teams');
        }

        return redirect()->route('teams.index')->with('success', 'Team added.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function show(Team $team)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function edit(Team $team)
    {
        $categories = Teamcategory::all();
        return view('admin.team.edit', compact('team', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Team $team)
    {
        $this->validate($request, [
            'teamcategory_id' => 'required',            
            'name' => 'required',            
            'position' => 'required',
            'details' => 'required',            
        ]);

        $team->teamcategory_id = $request->teamcategory_id;
        $team->name = $request->name;
        $team->position = $request->position;
        $team->email = $request->email;
        $team->phone = $request->phone;
        $team->details = $request->details;
        $team->save();

        if ($request->hasFile('image')) {
            $image_name = 'team-'.$team->id . '.'.$request->image->extension();
            $path = $request->image->move('uploads/teams/', $image_name);
            $team->image = $image_name;
            $team->save();
            $team->imageThumb($path, 'teams');
        }
        return redirect()->route('teams.index')->with('success', 'Team saved.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function destroy(Team $team)
    {
        if($team){

            if($team->image){
                $image = public_path('uploads/teams/' . $team->image);
                if(file_exists($image)){
                    unlink($image);
                }
            }

            if($team->delete()){
                return redirect()->route('teams.index')->with('success', 'Team deleted.');
            }else{
                return redirect()->route('teams.index')->with('error', 'Error while deleting Team.');
            }

        }else{
            abort();
        }
    }

    public function order(Request $request)
    {
        foreach ($request->data as $odr => $id) {
            $odr = $odr + 1;
            $team = Team::find($id);
            $team->order_by = $odr;
            $team->save();
        }
    }
}
