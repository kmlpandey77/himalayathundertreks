<?php

namespace App\Http\Controllers\Admin;

use App\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['settings'] = Setting::paginate(10);
        $data['google_script'] = Setting::where('title','google')->first();
        $data['bing_script'] = Setting::where('title','bing')->first();
        $data['yandex_script'] = Setting::where('title','yandex')->first();
        return view('admin.setting.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.setting.create');
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
            'title' => 'required|unique:settings',
            'value' => 'required'
        ]);

        $setting = new Setting;
        $setting->title = \Illuminate\Support\Str::slug($request->title, '_');
        $setting->value = $request->value;
        $setting->save();

        return redirect()->route('settings.index')->with('success', 'Setting added.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Setting $setting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Setting $setting)
    {
        return view('admin.setting.edit', compact('setting'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Setting $setting)
    {
        $this->validate($request, [
            'value' => 'required'
        ]);

        $setting->value = $request->value;
        $setting->save();

        return redirect()->route('settings.index')->with('success', 'Setting saved.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Setting $setting)
    {
        if($setting && $setting->delete()){
            return redirect()->route('settings.index')->with('success', 'Setting deleted.');
        }else{
            return redirect()->route('settings.index')->with('error', 'Error while deleting Setting.');
        }
    }

    public function showhide(Setting $setting)
    {
        if($setting->status){
            $setting->status = 0;
        }else{
            $setting->status = 1;
        }
        $setting->save();
        return redirect()->route('settings.index')->with('success', 'Status Updated.');        
    }

    public function script(Request $request)
    {
        $script = new Setting;
        $script->title = \Illuminate\Support\Str::slug($request->script_title,'_');
        $script->value = $request->script;
        $script->status = $request->status?:0;
        $script->save();
        return redirect()->route('settings.index')->with('success', 'Setting added.');
    }

    public function changescript(Request $request, Setting $setting)
    {
        $setting->title = \Illuminate\Support\Str::slug($request->script_title,'_');
        $setting->value = $request->script;
        $setting->status = $request->status?:0;
        $setting->save();
        return redirect()->route('settings.index')->with('success', $request->script_title.' '.'script changed.');
    }
}
