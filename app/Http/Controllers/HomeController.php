<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['page'] = \Cache::remember('home', now()->addDays(15), function(){
            return \App\Page::home()->first();
        });



        $data['slides'] = \Cache::remember('home_slides', now()->addDays(15), function(){
            $slides = \App\Slide::select('title', 'image')->home()->take(6)->get();
            $data = [];
            foreach($slides as $slide){
                $data[] = array(
                    'title' => $slide->title,
                    'image_path' => $slide->image_path,
                    'webp' => $slide->webp('1600x650'),
                    'webp_sm' => $slide->webp('800x325'),
                );
            }
            return $data;
        });

        $data['activies'] = \Cache::remember('activies', now()->addDays(15), function(){
            $activies = \App\Activity::select('title', 'slug', 'menu_title', 'image', 'details')->active()->take(5)->get();
            $data = [];
            foreach($activies as $activity){
                $data[] = array(
                    'title' => $activity->title,
                    'menu_title' => $activity->menu_title,
                    'url' => $activity->url,
                    'image_path' => $activity->image_path,
                    'details' => \Illuminate\Support\Str::limit(strip_tags($activity->details), 70),
                );
            }
            return $data;
        });

        // $data['feature_trip'] = \Cache::remember('feature_trip', now()->addDays(15), function(){

        //     if($feature_trip = \App\Tag::find(1)){
        //         $feature_trip = $feature_trip->packages()->select('title', 'slug', 'image', 'details', 'grade', 'duration', 'price')->take(6)->get();
        //         $data = [];
        //         foreach($feature_trip as $trip){
        //             $data[] = array(
        //                 'title' => $trip->title,
        //                 'menu_title' => $trip->menu_title,
        //                 'url' => $trip->url,
        //                 'image_path' => $trip->image_path,
        //                 'details' => \Illuminate\Support\Str::limit(strip_tags($trip->details), 100),
        //                 'duration' => $trip->days(),
        //                 'price' => $trip->price,
        //                 'max_altitude' => $trip->max_altitude,
        //             );
        //         }

        //         return $data;
        //     }
        //     return [];

        // });

        $data['feature_trip'] = [];
        $data['best_selling'] = [];
        if($feature_trip = \App\Tag::find(1)){
            $data['feature_trip'] = $feature_trip->packages()->with('facts')->take(10)->get();
        }

        if($best_selling = \App\Tag::find(2)){
            $data['best_selling'] = $best_selling->packages()->with('facts')->take(10)->get();
        }

        $data['reviews'] = \App\Review::with('country')->where('status', 1)->orderBy('event_date', 'desc')->orderBy('created_at', 'desc')->take(3)->get();
        $data['blogs'] = \App\Blog::orderBy('event_date', 'desc')->orderBy('created_at', 'desc')->take(3)->get();
        return view('index', $data);
    }
}
