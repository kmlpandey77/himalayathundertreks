<?php

namespace App\Http\Controllers\Admin;

use App\Package;
use App\Tag;
use App\Region;
use App\Activity;
use App\Destination;
use App\Fact;
use App\Graph;
use App\Itinerary;
use App\Price;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PackageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $packages = Package::query();
        if($request->keyword){
            $like = '%'.$request->keyword.'%';
            $packages->where('title', 'like', $like);
        }

        if(isset($request->activity) && $request->activity)
        {
            $packages->where('category_id', $request->activity);

            if(!isset($request->region))
            {
                $packages->where('region_id', 0);
            }

            $packages->orderBy('order_by');

        }

        if(isset($request->region) && $request->region)
        {
            $packages->where('region_id', $request->region);
        }

        $data['packages'] = $packages->paginate(20);

        $data['regions'] = Region::all();
        $data['activities'] = Activity::all();


        return view('admin.package.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $destinations = Destination::all();
        $tags = Tag::active()->get();
        return view('admin.package.create', compact('destinations', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);
        $this->validate($request, [
            'category_id' => 'required',
            'title' => 'required|unique:packages',
            'details' => 'required',
        ]);
        $slug = $request->slug? $request->slug : $request->title;
        $slug = $slug == '/'? $slug : \Illuminate\Support\Str::slug($slug);

        $package = new Package;
        $package->category_id = $request->category_id;
        $package->region_id = $request->region_id;
        $package->title = $request->title;
        $package->slug = $slug;
        $package->details = $request->details;
        $package->meta_title = $request->meta_title;
        $package->meta_keyword = $request->meta_keyword;
        $package->meta_description = $request->meta_description;
        $package->price = $request->price1_pax?:0;
        $package->duration = $request->duration;
        $package->grade = $request->grade;
        $package->include = $request->include;
        $package->exclude = $request->exclude;
        $package->highlight = $request->highlight;
        $package->itinerary_note = $request->itinerary_note;
        $package->trip_details = $request->trip_details;
        $package->order_by = Package::ord_by($request->category_id, $request->region_id);
        $package->save();
        
        $price_detail = new Price;
        $price_detail->package_id = $package->id;
        $price_detail->title = '1 Pax';
        $price_detail->value = $request->price1_pax?:0;
        $price_detail->save();

        $price_detail = new Price;
        $price_detail->package_id = $package->id;
        $price_detail->title = '2 - 3 Pax';
        $price_detail->value = $request->price2_pax?:0;
        $price_detail->save();

        $price_detail = new Price;
        $price_detail->package_id = $package->id;
        $price_detail->title = '4 - 7 Pax';
        $price_detail->value = $request->price3_pax?:0;
        $price_detail->save();

        $price_detail = new Price;
        $price_detail->package_id = $package->id;
        $price_detail->title = '8+ Pax';
        $price_detail->value = $request->price4_pax?:0;
        $price_detail->save();

        if($request->tags){
            $tags = Tag::find($request->tags);
            $package->tags()->sync($tags);
        }

        if(count($request->facts['title'])){
            $i = 0;
            foreach ($request->facts['title'] as $title) {
                if($title && $request->facts['value'][$i]){
                    $fact = new Fact;
                    $fact->package_id = $package->id;
                    $fact->title = $title;
                    $fact->value = $request->facts['value'][$i];
                    $fact->order_by = (Fact::where('package_id', $package->id)->max('order_by') + 1);
                    $fact->save();
                }
                $i++;
            }
        }

        if(count($request->graphs['point'])){
            $i = 0;
            foreach ($request->graphs['point'] as $point) {
                if($point){
                    $graph = new Graph;
                    $graph->package_id = $package->id;
                    $graph->point = $point;
                    $graph->value = $request->graphs['value'][$i];
                    $graph->order_by = (Graph::where('package_id', $package->id)->max('order_by') + 1);
                    $graph->save();
                }
                $i++;
            }
        }

        if(count($request->itinerary['day'])){
            $i = 0;
            foreach ($request->itinerary['day'] as $day) {
                if($day && ($request->itinerary['outline'][$i] || $request->itinerary['outline'][$i])){
                    $itinerary = new Itinerary;
                    $itinerary->package_id = $package->id;
                    $itinerary->day = $day;
                    $itinerary->outline = $request->itinerary['outline'][$i];
                    $itinerary->details = $request->itinerary['details'][$i];
                    $itinerary->hour = $request->itinerary['hour'][$i];
                    $itinerary->accommodation = $request->itinerary['accommodation'][$i];
                    $itinerary->meal = $request->itinerary['meal'][$i];
                    $itinerary->order_by = (Itinerary::where('package_id', $package->id)->max('order_by') + 1);
                    $itinerary->save();
                }
                $i++;
            }
        }

        if ($request->hasFile('image')) {
            $image_name = $package->slug . '-'.$package->id . '.'.$request->image->extension();
            $path = $request->image->move('uploads/packages/', $image_name);
            $package->image = $image_name;
            $package->save();
            $package->imageCompress($path, 'packages', 'trip_thumb');
        }

        if ($request->hasFile('map')) {
            $image_name = $package->slug . '-map-'.$package->id . '.'.$request->map->extension();
            $path = $request->map->move('uploads/maps/', $image_name);
            $package->map = $image_name;
            $package->save();
        }

        if($request->save){
            return redirect()->route('packages.edit', [$package->id] + request()->all())->with('success', 'Package added.');
        }

        return redirect()->route('packages.index', request()->all())->with('success', 'Package added.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function show(Package $package)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function edit(Package $package)
    {
        $tags = Tag::active()->get();
        $destinations = Destination::all();
        return view('admin.package.edit', compact('package', 'destinations', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Package $package)
    {
        // dd($package,$package->price_detail);
        $previous = explode('?', url()->previous());

        $this->validate($request, [
            'category_id' => 'required',
            'title' => 'required|unique:packages,title,' . $package->id,
            'details' => 'required',
            ]);

        $slug = $request->slug? $request->slug : $request->title;
        $slug = $slug == '/'? $slug : \Illuminate\Support\Str::slug($slug);

        $package->category_id = $request->category_id;
        $package->region_id = $request->region_id;
        $package->title = $request->title;
        $package->slug = $slug;
        $package->details = $request->details;
        $package->meta_title = $request->meta_title;
        $package->meta_keyword = $request->meta_keyword;
        $package->meta_description = $request->meta_description;
        $package->type = $request->type;
        $package->price = $request->price1_pax?:0;
        $package->duration = $request->duration;
        $package->grade = $request->grade;
        $package->include = $request->include;
        $package->exclude = $request->exclude;
        $package->highlight = $request->highlight;
        $package->itinerary_note = $request->itinerary_note;
        $package->trip_details = $request->trip_details;
        $package->save();

        $pax = Price::where('package_id',$package->id)->where('title','1 Pax')->first();
        if(!$pax)
        {
            $pax = new Price;
        }
        $pax->package_id = $package->id;
        $pax->title = '1 Pax';
        $pax->value = $request->price1_pax?:0;
        $pax->save();

        $pax = Price::where('package_id',$package->id)->where('title','2 - 3 Pax')->first();
        if(!$pax)
        {
            $pax = new Price;
        }
        $pax->package_id = $package->id;
        $pax->title = '2 - 3 Pax';
        $pax->value = $request->price2_pax?:0;
        $pax->save();

        $pax = Price::where('package_id',$package->id)->where('title','4 - 7 Pax')->first();
        if(!$pax)
        {
            $pax = new Price;
        }
        $pax->package_id = $package->id;
        $pax->title = '4 - 7 Pax';
        $pax->value = $request->price3_pax?:0;
        $pax->save();

        $pax = Price::where('package_id',$package->id)->where('title','8+ Pax')->first();
        if(!$pax)
        {
            $pax = new Price;
        }
        $pax->package_id = $package->id;
        $pax->title = '8+ Pax';
        $pax->value = $request->price4_pax?:0;
        $pax->save();

        if($request->tags){
            $tags = Tag::find($request->tags);
            $package->tags()->sync($tags);
        }else{
            $package->tags()->detach();
        }

        if($request->facts_edit && count($request->facts_edit['title']) > 0){
            $i = 0;
            foreach ($request->facts_edit['title'] as $title) {
                $fact = Fact::find($request->facts_edit['id'][$i]);
                if($title){
                    $fact->title = $title;
                    $fact->value = $request->facts_edit['value'][$i];
                    $fact->save();
                }else{
                    $fact->delete();
                }
                $i++;
            }
        }

        if(count($request->facts['title']) > 0){
            $i = 0;
            foreach ($request->facts['title'] as $title) {
                if($title){
                    $fact = new Fact;
                    $fact->package_id = $package->id;
                    $fact->title = $title;
                    $fact->value = $request->facts['value'][$i];
                    $fact->order_by = (Fact::where('package_id', $package->id)->max('order_by') + 1);
                    $fact->save();
                }
                $i++;
            }
        }
        if($request->graphs_edit && count($request->graphs_edit['point']) > 0){
            $i = 0;
            foreach ($request->graphs_edit['point'] as $point) {
                $graph = Graph::find($request->graphs_edit['id'][$i]);
                if($point){
                    $graph->point = $point;
                    $graph->value = $request->graphs_edit['value'][$i];
                    $graph->save();
                }else{
                    $graph->delete();
                }
                $i++;
            }
        }

        if(count($request->graphs['point'])){
            $i = 0;
            foreach ($request->graphs['point'] as $point) {
                if($point){
                    $graph = new Graph;
                    $graph->package_id = $package->id;
                    $graph->point = $point;
                    $graph->value = $request->graphs['value'][$i];
                    $graph->order_by = (Graph::where('package_id', $package->id)->max('order_by') + 1);
                    $graph->save();
                }
                $i++;
            }
        }

        if($request->itinerary_edit && count($request->itinerary_edit['day']) > 0){
            $i = 0;
            foreach ($request->itinerary_edit['day'] as $day) {
                $itinerary = Itinerary::find($request->itinerary_edit['id'][$i]);
                if($day && ($request->itinerary_edit['outline'][$i] || $request->itinerary_edit['outline'][$i])){
                    $itinerary->day = $day;
                    $itinerary->outline = $request->itinerary_edit['outline'][$i];
                    $itinerary->details = $request->itinerary_edit['details'][$i];
                    $itinerary->hour = $request->itinerary_edit['hour'][$i];
                    $itinerary->accommodation = $request->itinerary_edit['accommodation'][$i];
                    $itinerary->meal = $request->itinerary_edit['meal'][$i];
                    $itinerary->save();
                }else{
                    $itinerary->delete();
                }
                $i++;
            }
        }

        if(count($request->itinerary['day']) > 0){
            $i = 0;
            foreach ($request->itinerary['day'] as $day) {
                if($day && ($request->itinerary['outline'][$i] || $request->itinerary['outline'][$i])){
                    $itinerary = new Itinerary;
                    $itinerary->package_id = $package->id;
                    $itinerary->day = $day;
                    $itinerary->outline = $request->itinerary['outline'][$i];
                    $itinerary->details = $request->itinerary['details'][$i];
                    $itinerary->hour = $request->itinerary['hour'][$i];
                    $itinerary->accommodation = $request->itinerary['accommodation'][$i];
                    $itinerary->meal = $request->itinerary['meal'][$i];
                    $itinerary->order_by = (Itinerary::where('package_id', $package->id)->max('order_by') + 1);
                    $itinerary->save();
                }
                $i++;
            }
        }

        if ($request->hasFile('image')) {
            if($package->image && file_exists(public_path('uploads/packages/'.$package->image))){
                unlink(public_path('uploads/packages/'.$package->image));
            }
            $image_name = $package->slug . '-'.$package->id . '.'.$request->image->extension();
            $path = $request->image->move('uploads/packages/', $image_name);
            $package->image = $image_name;
            $package->save();
            $package->imageCompress($path, 'packages', 'trip_thumb');
        }

        if ($request->hasFile('map')) {
            $image_name = $package->slug . '-map-'.$package->id . '.'.$request->map->extension();
            $path = $request->map->move('uploads/maps/', $image_name);
            $package->map = $image_name;
            $package->save();
        }

        if($request->save){
            return redirect()->route('packages.edit', [$package->id] + $_GET)->with('success', 'Package added.');
        }

        return redirect()->route('packages.index', $_GET)->with('success', 'Package saved.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function destroy(Package $package)
    {
        if($package){

            if($package->image){
                $image = public_path('uploads/packages/' . $package->image);
                if(file_exists($image)){
                    unlink($image);
                }
            }

            if($package->delete()){
                return redirect()->route('packages.index', $_GET)->with('success', 'Package deleted.');
            }else{
                return redirect()->route('packages.index', $_GET)->with('error', 'Error while deleting Package.');
            }

        }else{
            abort();
        }
    }

    public function order(Request $request)
    {
        // print_r($request->data);exit;
        foreach ($request->data as $odr => $id) {
            if($id){
                $odr = $odr + 1;
                $package = Package::find($id);
                $package->order_by = $odr;
                $package->save();
            }
        }
    }

    public function factdelete(Request $request)
    {
        $fact = Fact::find($request->id);
        if($fact){
            $fact->delete();
        }
        return ['status'=> 'success', 'message' => 'Fact Deleted.'];
    }

    public function showhide(Package $package)
    {
        if($package->status){
            $package->status = 0;
        }else{
            $package->status = 1;
        }
        $package->save();
        return redirect()->route('packages.index', $_GET)->with('success', 'Status Update.');
    }

    public function viewitinerary(Package $package)
    {
        return view('admin.package.viewitinerary', compact('package'));
    }

    public function itineraryorder(Request $request)
    {
        foreach ($request->data as $odr => $id) {
            if($id){
                $odr = $odr + 1;
                $itinerary = Itinerary::find($id);
                $itinerary->order_by = $odr;
                $itinerary->save();
            }
        }
        return route('packages.edit', $request->package_id);
    }

    public function factorder(Request $request)
    {
        foreach ($request->data as $odr => $id) {
            if($id){
                $odr = $odr + 1;
                $itinerary = Fact::find($id);
                $itinerary->order_by = $odr;
                $itinerary->save();
            }
        }
    }

    public function itinerarydelete(Itinerary $itinerary)
    {
        if($itinerary){
            $itinerary->delete();
        }
        return back()->with('success', 'Itinerary deleted.');
    }

}
