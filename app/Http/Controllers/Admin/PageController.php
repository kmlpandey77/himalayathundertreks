<?php

namespace App\Http\Controllers\Admin;

use App\Page;
use App\Menu;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $pages = Page::query();
        if($request->keyword){
            $like = '%'.$request->keyword.'%';
            $pages->where('title', 'like', $like);
        }

        if($request->filter){
            if($request->filter == 'main_menu'){
                $pages->whereIN('position', array(1,3))->orderBy('menu_order');
            }else if($request->filter == 'footer'){
                $pages->whereIN('position', array(2,3))->orderBy('footer_order');
            }else{
                $pages->where('parent_id', $request->filter)->orderBy('order_by');
            }
        }else{
            $pages->orderBy('parent_id')->orderBy('order_by');
        }

        $pages = $pages->paginate(15);
        $parents = Page::where('parent_id', 0)->get();
        return view('admin.page.index', compact('pages', 'parents'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $parents = Page::all();
        $menus = Menu::all();
        return view('admin.page.create', compact('parents', 'menus'));
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
            'title' => 'required|unique:pages',            
            'details' => 'required',
            ]);

        $slug = $request->slug? $request->slug : $request->title;
        $slug = $slug == '/'? $slug : \Illuminate\Support\Str::slug($slug);

        $page = new Page;
        $page->parent_id = $request->parent_id;
        $page->title = $request->title;
        $page->slug = $slug;
        $page->details = $request->details;
        $page->meta_title = $request->meta_title;
        $page->meta_keyword = $request->meta_keyword;
        $page->meta_description = $request->meta_description;
        $page->status = $request->status?:0;

        if($request->parent_id){
            $page->order_by = Page::where('parent_id', $request->parent_id)->max('order_by');
        }
        if(in_array($request->position, array(1,3))){
            $page->menu_order = Page::whereIn('position', array(1,3))->max('menu_order');
        }
        if(in_array($request->position, array(2,3))){
            $page->footer_order = Page::whereIn('position', array(2,3))->max('footer_order');
        }
        $page->save();

        if($request->menus){
            $menus = Menu::find($request->menus);
            $page->menus()->sync($menus);
        }

        if($request->save){
            return redirect()->route('pages.edit', $page->id)->with('success', 'page added.');
        }
        return redirect()->route('pages.index')->with('success', 'page added.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function show(Page $page)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function edit(Page $page)
    {
        $menus = Menu::all();
        $parents = Page::all();
        return view('admin.page.edit', compact('parents', 'page', 'menus'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Page $page)
    {
        $this->validate($request, [
            'title' => 'required|unique:pages,title,' . $page->id,            
            'details' => 'required',
            ]);

        $slug = $request->slug? $request->slug : $request->title;
        $slug = $slug == '/'? $slug : \Illuminate\Support\Str::slug($slug);

        $page->parent_id = $request->parent_id;
        $page->title = $request->title;
        $page->slug = $slug;
        $page->details = $request->details;
        $page->meta_title = $request->meta_title;
        $page->meta_keyword = $request->meta_keyword;
        $page->meta_description = $request->meta_description;
        $page->status = $request->status?:0;
        $page->save();

        if($request->menus){
            $menus = Menu::find($request->menus);
            $page->menus()->sync($menus);
        }else{
            $page->menus()->detach();            
        }

        if($request->save){
            return redirect()->route('pages.edit', $page->id)->with('success', 'page saved.');
        }

        return redirect()->route('pages.index')->with('success', 'Page saved.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function destroy(Page $page)
    {

        if($page){

            $page->menus()->detach();
            $page->delete();
            return redirect()->route('pages.index')->with('success', 'page deleted.');
        }else{
            return redirect()->route('pages.index')->with('error', 'Error while deleting page.');
        }
    }

    public function showhide(Page $page)
    {
        if($page->status){
            $page->status = 0;
        }else{
            $page->status = 1;
        }
        $page->save();
        return redirect()->route('pages.index')->with('success', 'Status Updated.');        
    }

    public function order(Request $request)
    {
        foreach ($request->data as $odr => $id) {
            if($id){                
                $odr = $odr + 1;
                $slide = Page::find($id);
                $slide->{$request->order} = $odr;
                $slide->save();
            }
        }
    }
}