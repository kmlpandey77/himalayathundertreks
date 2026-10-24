<?php
namespace App\Http\Controllers;

use App\Package;
use App\Country;
use App\Subscriber;

use App\Mail\Inquiry;
use App\Mail\TripBooking;
use App\Mail\AutoResponse;

use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $slug)
    {
        $data['countries'] = Country::all();
        $data['package'] = $package = Package::where('slug',$slug)->first();
        if(!$package){
            abort(404);
        }

        if($request->isMethod('post')){
            $this->validate($request, [
                'text_fname' => 'required',
                'text_lname' => 'required',
                'text_email' => 'required',
                // 'number_of_child_traveller' => 'required',
                'number_of_adult_traveller' => 'required',
                'check_in' => 'required',
                'texta_message' => 'required',
                'captcha' => 'required',
            ]);
            
            if (\Session::get('rand_pass') <> $request->captcha) {
                return redirect()->back()->withErrors(['captcha' => 'Invalid Cpatcha'])->withInput();
            }

            $subscriber = Subscriber::where('email', $request->text_email)->first();
            if(!$subscriber){
                $subscriber = new Subscriber;
                $subscriber->email = $request->text_email;
                $subscriber->name = $request->text_fname . ' ' . $request->text_lname;
                $subscriber->phone = $request->text_phone;
                $subscriber->save();
            }

            // return new TripBooking($request);
            Mail::send(new TripBooking($request));
            Mail::send(new AutoResponse($request->text_fname . ' ' .$request->text_fname, $request->text_email));

            // $body = view('emails.trip-booking', compact('request'));
            // $body = "$body";


            // $to = config('mail.from.name') ." <".config('mail.from.address').">";
            // $subject = "Trip Booking :: Explore Vacation";


            // $headers = "MIME-Version: 1.0" . "\r\n";
            // $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            // $headers .= "From: $request->text_fname $request->text_lname <$request->text_email>" . "\r\n";
            // $headers .= "Reply-To: $request->text_fname $request->text_lname <$request->text_email>" . "\r\n";

            // try{

            //     mail($to,$subject,$body,$headers);

            // }catch(Exception $e){

            //     dd($e);

            // }

            return redirect()->route('thankyou');
        }
        return view('booking', $data);
    }

    public function thankyou(Request $request)
    {
        // dd($request);
        $msg = null;
        if($request->has('page') && $request->page == 'subscribe'){
            $msg = 'Thank you for subscribing to our newsletter';
        }
        if($request->has('page') && $request->page == 'review'){
            $msg = 'Thank you for Your review!!';
        }
        return view('thankyou', compact('msg'));
    }

    public function inquiry(Request $request)
    {
        $this->validate($request, [
            'full_name' => 'required',
            'email' => 'required',
            'country' => 'required',
            'message' => 'required',
            'captcha' => 'required',
        ]);


        if(\Session::get('rand_pass') <> $request->captcha){
            return redirect()->back()->withErrors(['inquiry_captcha' => 'Invalid Cpatcha'])->withInput();
        }

        $subscriber = Subscriber::where('email', $request->email)->first();
        if(!$subscriber){
            $subscriber = new Subscriber;
            $subscriber->email = $request->email;
            $subscriber->name = $request->full_name;
            $subscriber->phone = $request->phone;
            $subscriber->save();
        }


        // return new Inquiry($request);
        // return new AutoResponse($request->full_name, $request->email);
        Mail::send(new Inquiry($request));
        Mail::send(new AutoResponse($request->full_name, $request->email));

        return redirect()->route('thankyou');
    }

    public function requestcallback(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
        ]);

        $subscriber = Subscriber::where('email', $request->email)->first();
        if(!$subscriber){
            $subscriber = new Subscriber;
            $subscriber->email = $request->email;
            $subscriber->name = $request->name;
            $subscriber->phone = $request->phone;
            $subscriber->save();
        }


        Mail::send(new RequestCallback($request));
        return redirect()->route('thankyou');
    }

    public function downloadbrochure(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
            'country' => 'required',
        ]);

        $subscriber = Subscriber::where('email', $request->email)->first();
        if(!$subscriber){
            $subscriber = new Subscriber;
            $subscriber->email = $request->email;
            $subscriber->name = $request->name;
            $subscriber->country = $request->country;
            $subscriber->save();
        }
        return redirect('download/brochure.pdf');
    }

    public function subscriber(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
        ]);

        $subscriber = Subscriber::where('email', $request->email)->first();
        if(!$subscriber){
            $subscriber = new Subscriber;
            $subscriber->email = $request->email;
            $subscriber->name = $request->name;
            $subscriber->country = $request->country;
            $subscriber->save();
        }
        return redirect()->route('thankyou', ['page'=>'subscribe']);
    }
}
