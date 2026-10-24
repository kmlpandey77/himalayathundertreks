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
                'email' => 'required',
                'message' => 'required',
                'captcha' => 'required',
            ]);
            if (\Session::get('rand_pass') <> $request->captcha) {
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

    // public function hotelbooking($id)
    // {
    //     $hotel =  Hotel::find($id);
    //     return view('hotelbooking', compact('hotel'));
    // }

    public function hotelbooking(Request $request)
    {
        if($request->isMethod('post')){
            $body = view('emails.hotel-booking', compact('request'));
            // return $body;
            $body = "$body";


            $to = config('mail.from.name') ." <".config('mail.from.address').">";
            $subject = "Hotel Booking :: Explore Vacation";


            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            $headers .= "From: $request->name <$request->email>" . "\r\n";
            $headers .= "Reply-To: $request->name <$request->email>" . "\r\n";
            $headers .= 'Bcc: ' . config('mail.from.name') . '<sales.explorevacation@gmail.com>' . "\r\n";

            try{

                mail($to,$subject,$body,$headers);

             }catch(Exception $e){

                dd($e);

             }

            return redirect()->route('thankyou');
        }

        $data['hotel'] = Hotel::find($request->id);
        return view('hotelbooking', $data);
    }
}