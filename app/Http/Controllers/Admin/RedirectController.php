<?php

namespace App\Http\Controllers\Admin;

use App\Redirect;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RedirectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $redirects = Redirect::paginate(10);
        return view('admin.redirect.index', compact('redirects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pages = ['global', 'home'];        
        return view('admin.redirect.create', compact('pages'));
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
            'from_url' => 'required',            
            'to_url' => 'required'
        ]);

        $from_url = parse_url($request->from_url, PHP_URL_PATH);
        $to_url = parse_url($request->to_url, PHP_URL_PATH);

        $redirect = new Redirect;
        $redirect->from_url = ltrim($from_url,'/');
        $redirect->to_url = ltrim($to_url,'/');
        $redirect->save();

        return redirect()->route('redirects.index')->with('success', 'Redirect added.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Redirect  $redirect
     * @return \Illuminate\Http\Response
     */
    public function show(Redirect $redirect)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Redirect  $redirect
     * @return \Illuminate\Http\Response
     */
    public function edit(Redirect $redirect)
    {
        return view('admin.redirect.edit', compact('redirect'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Redirect  $redirect
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Redirect $redirect)
    {
        $this->validate($request, [
            'from_url' => 'required',            
            'to_url' => 'required'
        ]);

        $from_url = parse_url($request->from_url, PHP_URL_PATH);
        $to_url = parse_url($request->to_url, PHP_URL_PATH);
        
        $redirect->from_url = ltrim($from_url,'/');
        $redirect->to_url = ltrim($to_url,'/');
        $redirect->save();

        return redirect()->route('redirects.index')->with('success', 'Redirect saved.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Redirect  $redirect
     * @return \Illuminate\Http\Response
     */
    public function destroy(Redirect $redirect)
    {
        if($redirect && $redirect->delete()){
            return redirect()->route('redirects.index')->with('success', 'Redirect deleted.');
        }else{
            return redirect()->route('redirects.index')->with('error', 'Error while deleting Redirect.');
        }
    }
}
