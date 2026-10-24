<?php

namespace App\Http\Controllers\Admin;

use App\Teamcategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TeamcategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $teamcategories = Teamcategory::orderBy('order_by')->paginate(10);
        return view('admin.teamcategory.index', compact('teamcategories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.teamcategory.create');
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
            'title' => 'required',
        ]);

        $teamcategory = new Teamcategory;
        $teamcategory->title = $request->title;
        $teamcategory->slug = \Illuminate\Support\Str::slug($request->title);
        $teamcategory->order_by = (Teamcategory::max('order_by') + 1);
        $teamcategory->save();

        return redirect()->route('teamcategories.index')->with('success', 'Team category added.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Teamcategory  $teamcategory
     * @return \Illuminate\Http\Response
     */
    public function show(Teamcategory $teamcategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Teamcategory  $teamcategory
     * @return \Illuminate\Http\Response
     */
    public function edit(Teamcategory $teamcategory)
    {
        return view('admin.teamcategory.edit', compact('teamcategory'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Teamcategory  $teamcategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Teamcategory $teamcategory)
    {
        $this->validate($request, [
            'title' => 'required',            
        ]);

        $teamcategory->title = $request->title;
        $teamcategory->slug = \Illuminate\Support\Str::slug($request->title);
        $teamcategory->save();               
        return redirect()->route('teamcategories.index')->with('success', 'Team Category saved.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Teamcategory  $teamcategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(Teamcategory $teamcategory)
    {
        if($teamcategory){

            if($teamcategory->delete()){
                return redirect()->route('teamcategories.index')->with('success', 'Team deleted.');
            }else{
                return redirect()->route('teamcategories.index')->with('error', 'Error while deleting Team.');
            }

        }else{
            abort();
        }
    }

    public function order(Request $request)
    {
        foreach ($request->data as $odr => $id) {
            $odr = $odr + 1;
            $category = Teamcategory::find($id);
            $category->order_by = $odr;
            $category->save();
        }
    }
}
