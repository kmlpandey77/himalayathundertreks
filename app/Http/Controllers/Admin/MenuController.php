<?php

namespace App\Http\Controllers\Admin;

use App\Menu;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $menus = Menu::query();
        $menus = $menus->paginate(15);
        return view('admin.menu.index', compact('menus'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.menu.create');
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
            'menu' => 'required|unique:menus',
            ]);

        $menu = new Menu;
        $menu->menu = $request->menu;
        $menu->status = $request->status?:0;
        $menu->save();

        if($request->save){
            return redirect()->route('menus.edit', $menu->id)->with('success', 'Menu added.');
        }
        return redirect()->route('menus.index')->with('success', 'Menu added.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function show(Menu $menu)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function edit(Menu $menu)
    {
        return view('admin.menu.edit', compact('menu'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Menu $menu)
    {
        $this->validate($request, [
            'menu' => 'required|unique:menus,menu,' . $menu->id,
            ]);

        $menu->menu = $request->menu;
        $menu->status = $request->status?:0;
        $menu->save();

        if($request->save){
            return redirect()->route('menus.edit', $menu->id)->with('success', 'Menu saved.');
        }

        return redirect()->route('menus.index')->with('success', 'Menu saved.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function destroy(Menu $menu)
    {
        if($menu && $menu->delete()){
            return redirect()->route('menus.index')->with('success', 'Menu deleted.');
        }else{
            return redirect()->route('menus.index')->with('error', 'Error while deleting Menu.');
        }
    }

    public function showhide(Menu $menu)
    {
        if($menu->status){
            $menu->status = 0;
        }else{
            $menu->status = 1;
        }
        $menu->save();
        return redirect()->route('menus.index')->with('success', 'Status Updated.');        
    }
}
