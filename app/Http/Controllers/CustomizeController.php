<?php

namespace App\Http\Controllers;

use App\Package;
use App\Country;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

use App\Subscriber;

use App\Mail\CustomizeTrip;
use App\Mail\AutoResponse;

class CustomizeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->validate($request, [
            'full_name' => 'required',
            'email' => 'required',
            'number_of_traveller' => 'required',
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
            $subscriber->name = $request->full_name;
            $subscriber->phone = $request->phone;
            $subscriber->save();
        }


        // return new CustomizeTrip($request);
        Mail::send(new CustomizeTrip($request));
        Mail::send(new AutoResponse($request->full_name, $request->email));

        // $body = view('emails.customize-trip', compact('request'));
        // $body = "$body";


        // $to = config('mail.from.address') ."<".config('mail.from.name').">";
        // $subject = "Customize Trip :: Explore Vacation";


        // $headers = "MIME-Version: 1.0" . "\r\n";
        // $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        // $headers .= "From: $request->full_name $request->text_lname <$request->email>" . "\r\n";
        // $headers .= "Reply-To: $request->full_name $request->text_lname <$request->email>" . "\r\n";


        // try{

        //     mail($to,$subject,$body,$headers);

        //  }catch(Exception $e){

        //     dd($e);

        //  }
        return redirect()->route('thankyou');
    }
}
