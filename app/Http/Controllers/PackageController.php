<?php

namespace App\Http\Controllers;

use App\Package;
use App\Menu;

use Illuminate\Http\Request;

class PackageController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data['package'] = $package = Package::where('slug',$request->path())->first();
        $data['slides'] = $package->slides;
        $infoMenu = Menu::find(4);
        $data['infos'] = $infoMenu ? $infoMenu->pages : null;
        $data['review'] = $package->reviews()->active()->first(); // approved only
        $data['trip_details'] = null;
        $data['checklist'] = null;

        // if($package->activity && $package->activity->destination->id == 1){
        //     $data['trip_details'] = \App\Page::find(11);
        // }

        if($package->activity && $package->activity->id == 1){
            $data['checklist'] = \App\Page::find(13);
        }

        if($package->activity && $package->activity->id == 3){
            $data['checklist'] = \App\Page::find(14);
        }

        return view('package', $data);
    }
}
