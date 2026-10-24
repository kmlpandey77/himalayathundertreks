<?php

namespace App\Http\Controllers\Admin;

use App\Label;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LabelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $labels = Label::paginate(10);
        return view('admin.label.index', compact('labels'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pages = ['global', 'home'];        
        return view('admin.label.create', compact('pages'));
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
            'page' => 'required',            
            'labelid' => 'required|unique:labels'
        ]);

        $label = new Label;
        $label->page = $request->page;
        $label->labelid = $request->page.':'.$request->labelid;
        $label->value = $request->value;
        $label->save();

        return redirect()->route('labels.index')->with('success', 'Label added.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Label  $label
     * @return \Illuminate\Http\Response
     */
    public function show(Label $label)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Label  $label
     * @return \Illuminate\Http\Response
     */
    public function edit(Label $label)
    {
        $pages = ['global', 'home']; 
        return view('admin.label.edit', compact('pages', 'label'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Label  $label
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Label $label)
    {
        $this->validate($request, [
            'labelid' => 'required',
            ]);

        $label->value = $request->value;
        $label->save();

        return redirect()->route('labels.index')->with('success', 'Label saved.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Label  $label
     * @return \Illuminate\Http\Response
     */
    public function destroy(Label $label)
    {
        if($label && $label->delete()){
            return redirect()->route('labels.index')->with('success', 'Label deleted.');
        }else{
            return redirect()->route('labels.index')->with('error', 'Error while deleting Label.');
        }
    }
}
