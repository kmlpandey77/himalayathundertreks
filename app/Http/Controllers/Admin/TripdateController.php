<?php

namespace App\Http\Controllers\Admin;

use App\Date;
use App\Package;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TripdateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($trip)
    {
        $trip = Package::find($trip);
        $dates = Date::where('package_id', $trip->id)->get();
        return view('admin.tripdate.index', compact('dates', 'trip'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($trip)
    {
        return view('admin.tripdate.create', compact('trip'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $trip)
    {
        // dd($request);
        $this->validate($request, [
            'start' => 'required',
            'end' => 'required',
            'status' => 'required',
        ]);

        $date = new Date;
        $date->package_id = $trip;
        $date->start = $request->start;
        $date->end = $request->end;
        $date->price = $request->price;
        $date->status = $request->status;
        // $date->is_fullmoon = $request->is_fullmoon?:0;
        $date->save();

        return redirect()->route('tripdates.index', $trip)->with('success', 'Date added.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Date  $date
     * @return \Illuminate\Http\Response
     */
    public function show(Date $date)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Date  $date
     * @return \Illuminate\Http\Response
     */
    public function edit(Date $date)
    {
        $trip = $date->package_id;
        return view('admin.tripdate.edit', compact('date','trip'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Date  $date
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Date $date)
    {
        $this->validate($request, [
            'start' => 'required',
            'end' => 'required',
            'status' => 'required',
        ]);

        $date->start = $request->start;
        $date->end = $request->end;
        $date->price = $request->price;
        $date->status = $request->status;
        // $date->is_fullmoon = $request->is_fullmoon?:0;
        $date->save();

        return redirect()->route('tripdates.index', $date->package_id)->with('success', 'Date saved.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Date  $date
     * @return \Illuminate\Http\Response
     */
    public function destroy(Date $date)
    {
        if($date){
            $trip = $date->package_id;
            if($date->delete()){
                return redirect()->route('tripdates.index', $trip)->with('success', 'Date deleted.');
            }else{
                return redirect()->route('tripdates.index', $trip)->with('error', 'Error while deleting Date.');
            }

        }else{
            abort();
        }

    }
}
