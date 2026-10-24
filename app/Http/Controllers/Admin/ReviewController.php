<?php

namespace App\Http\Controllers\Admin;

use App\Review;
use App\Package;
use App\Country;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reviews = Review::paginate(10);
        return view('admin.review.index', compact('reviews'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $packages = Package::all();
        $countries = Country::all();
        return view('admin.review.create', compact('packages', 'countries'));
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
            'name' => 'required',
            'country_id' => 'required',
            'details' => 'required',
        ]);

        $review = new Review;
        $review->name = $request->name;
        $review->email = $request->email;
        $review->country_id = $request->country_id;
        $review->title = $request->title;
        $review->link = $request->link;
        $review->package_id = $request->package_id;
        $review->event_date = $request->event_date;
        $review->details = $request->details;
        $review->rating = $request->rating;
        $review->save();

        if ($request->hasFile('image')) {
            $image_name = 'review-'.$review->id . '.'.$request->image->extension();
            $path = $request->image->move('uploads/reviews/', $image_name);
            $review->image = $image_name;
            $review->save();
            $review->imageCompress($path, 'reviews', 'review_thumb');
        }

        return redirect()->route('reviews.index')->with('success', 'Review added.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function show(Review $review)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function edit(Review $review)
    {
        $packages = Package::all();
        $countries = Country::all();
        return view('admin.review.edit', compact('review', 'packages', 'countries'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Review $review)
    {
        $this->validate($request, [
            'title' => 'required',
            'name' => 'required',
            'country_id' => 'required',
            'details' => 'required',
        ]);

        $review->name = $request->name;
        $review->email = $request->email;
        $review->country_id = $request->country_id;
        $review->title = $request->title;
        $review->link = $request->link;
        $review->package_id = $request->package_id;
        $review->event_date = $request->event_date;
        $review->details = $request->details;
        $review->rating = $request->rating;
        $review->save();

        if ($request->hasFile('image')) {
            $image_name = 'review-'.$review->id . '.'.$request->image->extension();
            $path = $request->image->move('uploads/reviews/', $image_name);
            $review->image = $image_name;
            $review->save();
            $review->imageCompress($path, 'reviews', 'review_thumb');
        }
        return redirect()->route('reviews.index')->with('success', 'Review saved.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function destroy(Review $review)
    {
        if($review){

            if($review->image){
                $image = public_path('uploads/reviews/' . $review->image);
                if(file_exists($image)){
                    unlink($image);
                }
            }

            if($review->delete()){
                return redirect()->route('reviews.index')->with('success', 'Review deleted.');
            }else{
                return redirect()->route('reviews.index')->with('error', 'Error while deleting Review.');
            }

        }else{
            abort();
        }
    }

    public function decline($id)
    {
        $data = array(
            'status' => -1,
        );
        if(Review::where('id',$id)->update($data))
        {
            return redirect()->route('reviews.index')->with('success','Review was declined');
        }
    }

    public function approve($id)
    {
        $review = Review::find($id);

        $data = array(
            'status' => 1,
        );

        if(Review::where('id',$review->id)->update($data))
        {
            return redirect()->route('reviews.index')->with('success','Review Request was approved');
        }
    }
}
