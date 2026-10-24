<?php

namespace App\Http\Controllers;

use App\Page;
use App\Team;
use App\Teamcategory;
use App\Legaldoc;
use App\Subscriber;
use App\Blog;
use App\City;
use App\Hotel;
use App\Video;
use App\Album;

use App\Mail\AutoResponse;
use App\Mail\Contact;
use Illuminate\Support\Facades\Mail;

use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data['page'] = $page =  Page::where('slug',$request->path())->first();
        if($page->id==2){
            $data['teams'] = Team::all();
            $data['docs'] = Legaldoc::all();
        }
        $data['parent'] = $page->parent;
        $data['sidebar'] = $page->parent ? $page->parent->child : null;
        $data['blogs'] = Blog::orderby('event_date','desc')->limit(5)->get();
        return view('page', $data);
    }

    public function ourteam(Request $request)
    {
        $data['page'] = $page = Page::where('slug',$request->path())->first();
        $data['sidebar'] = Page::where('parent_id',$page->parent_id)->get();
        $data['teams'] = Team::all();
        return view('our-team', $data);
    }

    public function legaldoc(Request $request)
    {
        $data['page'] = $page = Page::where('slug',$request->path())->first();
        $data['legaldocs'] = Legaldoc::all();
        return view('legaldoc', $data);
    }

    public function contact(Request $request)
    {
        if($request->isMethod('post')){
            $this->validate($request, [
                'name' => 'required',
                'email' => 'required|email|max:150',
                'message' => 'required',
                'captcha' => 'required',
            ]);
            if (\Session::pull('rand_pass') <> $request->captcha) {
                return redirect()->back()->withErrors(['captcha' => 'Invalid Cpatcha'])->withInput();
            }
            $subscriber = Subscriber::where('email', $request->email)->first();
            if(!$subscriber){
                $subscriber = new Subscriber;
                $subscriber->email = $request->email;
                $subscriber->name = $request->name;
                $subscriber->phone = $request->phone;
                $subscriber->save();
            }

            // return new Contact($request);
            // return new AutoResponse($request->name, $request->email);

            Mail::send(new Contact($request));
            Mail::send(new AutoResponse($request->name, $request->email));

            return redirect()->route('thankyou');
        }

        $data['page'] = $page = Page::where('slug',$request->path())->first();
        return view('contact', $data);
    }

    public function video(Request $request)
    {
        $data['page'] = $page = Page::where('slug',$request->path())->first();
        $data['videos'] = Video::all();
        return view('video', $data);
    }

    public function photo(Request $request)
    {
        $data['page'] = $page = Page::where('slug',$request->path())->first();
        $data['albums'] = Album::all();
        return view('photo', $data);
    }

    public function viewphoto(Album $album)
    {
        return view('viewphoto', compact('album'));
    }

    /**
     * llms.txt: a plain-text map of the site for AI assistants and answer engines.
     */
    public function llms()
    {
        $body = \Cache::remember('llms_txt', now()->addHours(6), function () {
            $activities = \App\Activity::active()->get(['id', 'title', 'slug']);
            foreach ($activities as $activity) {
                $activity->tripList = \App\Package::active()->where('category_id', $activity->id)
                    ->orderBy('region_id')->orderBy('order_by')
                    ->get(['id', 'title', 'slug', 'duration']);
            }
            $pages = Page::active()
                ->whereNotIn('slug', ['home', '/', 'blogs', 'reviews', 'contact', 'photo-gallery', 'video-gallery'])
                ->orderBy('order_by')->get(['title', 'slug']);
            $blogs = Blog::active()->orderBy('event_date', 'desc')->orderBy('created_at', 'desc')->take(20)->get(['id', 'title', 'slug']);

            return view('llms', compact('activities', 'pages', 'blogs'))->render();
        });

        return response($body)->header('Content-Type', 'text/plain; charset=UTF-8');
    }

    public function sitemap(){
        return response(view('sitemap'))
        ->header('Content-Type', 'application/xml');
    }

    public function faqs(Request $request)
    {
        $data['blogs'] = Blog::orderby('event_date','desc')->limit(5)->get();

        $data['page'] = $page =  Page::where('slug',$request->path())->first();
        $details = preg_split('#(\r\n?|\n)+#', strip_tags($page->details));
        $faqs = [];
        $number = 1;
        $answer = null;
        foreach ($details as $value) {
            if(Page::endsWith($value)){
                $faqs[$number]['question'] = $value;
                if($number <> 1){
                    $faqs[($number-1)]['answer'] = $answer;
                    $answer = null;
                }
                $number++;
            }else{
                $answer .= '<p>' . $value . '</p>';
            }
        }
        $faqs[($number-1)]['answer'] = $answer;
        $data['faqs'] = $faqs;
        return view('faqs', $data);
    }

    public function dailydeals(Request $request)
    {
        $data['page'] = $page =  Page::where('slug',$request->path())->first();
        $data['dailydeals'] = $page->child;
        $data['blogs'] = Blog::orderby('event_date','desc')->limit(5)->get();
        return view('dailydeals', $data);
    }

    public function city(Request $request)
    {
        $city =  City::where('slug',$request->path())->first();
        return view('city', compact('city'));
    }

}