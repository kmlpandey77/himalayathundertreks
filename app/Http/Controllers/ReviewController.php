<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Review;
use App\Page;
use App\Package;
use App\Country;

class ReviewController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $page =  Page::where('slug',$request->path())->first();
        $reviews = Review::latest()->paginate(10);
        return view('reviews', compact('reviews', 'page'));
    }


    public function writereview()
    {
        $packages = Package::all();
        $countries = Country::all();
        return view('write-review', compact('packages', 'countries'));
    }

    public function reviewstore(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'name' => 'required',
            'country_id' => 'required',
            'details' => 'required',
            'email' => 'nullable|email|max:150',
            'captcha' => 'required',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);
        // dd($request);
        if (\Session::pull('rand_pass') <> $request->captcha) {
            return redirect()->back()->withErrors(['captcha' => 'Invalid Cpatcha'])->withInput();
        }

        $review = new Review;
        $review->name = $request->name;
        $review->email = $request->email;
        $review->country_id = $request->country_id;
        $review->title = $request->title;
        $review->package_id = $request->package_id;
        // Public submissions are plain text; reviews are rendered unescaped, so escape here.
        $review->details = nl2br(e($request->details));
        $review->rating = $request->rating;
        $review->save();

        if ($request->hasFile('image')) {
            $image_name = 'review-'.$review->id . '.'.$request->image->guessExtension();
            $path = $request->image->move('uploads/reviews/', $image_name);
            $review->image = $image_name;
            $review->save();
        }

        return redirect()->route('thankyou', ['page'=>'review']);
    }


}
