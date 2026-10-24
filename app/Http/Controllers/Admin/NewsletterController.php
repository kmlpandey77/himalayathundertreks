<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Newsletter;
use App\Subscriber;
use App\SubscriberGroup;

use App\Mail\Newsletters;
use Illuminate\Support\Facades\Mail;

class NewsletterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['newsletters'] = Newsletter::paginate(25);
        return view('admin.newsletter.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $subscriber_groups = SubscriberGroup::all();
        return view('admin.newsletter.create', compact('subscriber_groups'));
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
            'image' => 'mimes:jpg,png,jpeg',
            'html_file' => 'mimes:html',
        ]);

        $newsletter = new Newsletter;
        $newsletter->title = $request->title;
        $newsletter->type = $request->type;
        $newsletter->subscriber_group_id = $request->subscriber_groups ?: 0;
        $newsletter->save();

        if($request->type == 'plain')
        {
            $newsletter->details = $request->details;
            if ($request->hasFile('image')) {
                $image_name = \Illuminate\Support\Str::slug($request->title) .'-'. $request->type . '.'.$request->image->extension();
                $path = $request->image->move('uploads/newsletter/image/', $image_name);
                $newsletter->image = $image_name;
                $newsletter->save();
            }

            if($request->all_subscribers)
            {
                $groups = SubscriberGroup::all();
                foreach($groups as $group)
                {
                    foreach($group->subscribers as $sg)
                    {
                        $subs[] = $sg->id;
                    }
                }
                foreach($subs as $key => $value)
                {
                    $sub = Subscriber::find($value);
                    Mail::send(new Newsletters($newsletter, $sub->email));
                }
            }
            else
            {
                foreach($request->subscriber_groups as $value)
                {
                    $sub_group = SubscriberGroup::find($value);
                    // dd($sub_group->subscribers);
                    foreach($sub_group->subscribers as $subscriber)
                    {
                        Mail::send(new Newsletters($newsletter, $subscriber->email));
                    }
                }
            }
        }
        else
        {
            if ($request->hasFile('html_file')) {
                $image_name = \Illuminate\Support\Str::slug($request->title) . '-'. $request->type . '.'.$request->html_file->extension();
                $path = $request->html_file->move('uploads/newsletter/html_file/', $image_name);
                $newsletter->html_file = $image_name;
                $newsletter->save();
            }

            if($request->all_subscribers)
            {
                $groups = SubscriberGroup::all();
                foreach($groups as $group)
                {
                    foreach($group->subscribers as $sg)
                    {
                        $subs[] = $sg->id;
                    }
                }
                
                foreach($subs as $key => $value)
                {
                    $file = public_path('uploads/newsletter/html_file/'.$newsletter->html_file);
                    $content = file_get_contents($file);

                    $sub = Subscriber::find($value);
                    Mail::send([], [], function ($message) use ($content, $sub, $newsletter) {
                      $message->to($sub->email)
                        ->subject($newsletter->title)
                        ->html($content);
                    });
                }
            }
            else
            {
                foreach($request->subscriber_groups as $value)
                {
                    $sub_group = SubscriberGroup::find($value);
                    // dd($sub_group->subscribers);
                    foreach($sub_group->subscribers as $subscriber)
                    {
                        $file = public_path('uploads/newsletter/html_file/'.$newsletter->html_file);
                        $content = file_get_contents($file);

                        Mail::send([], [], function ($message) use ($content, $subscriber, $newsletter) {
                          $message->to($subscriber->email)
                            ->subject($newsletter->title)
                            ->html($content);
                        });
                    }
                }
            }
        }

        return redirect()->route('newsletters.index')->with('success','Newsletter Added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Newsletter $newsletter)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Newsletter $newsletter)
    {
        $subscriber_groups = SubscriberGroup::all();
        return view('admin.newsletter.edit', compact('newsletter','subscriber_groups'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Newsletter $newsletter)
    {
        $this->validate($request, [
            'title' => 'required',
            'image' => 'mimes:jpg,png,jpeg',
            'html_file' => 'mimes:html',
        ]);
        
        // dd($request);

        $newsletter->title = $request->title;
        $newsletter->type = $request->type;
        $newsletter->subscriber_group_id = $request->subscriber_groups;

        if($request->type == 'plain')
        {
            $newsletter->details = $request->details;
            $newsletter->html_file = null;
            if ($request->hasFile('image')) {
                if($newsletter->image && file_exists(public_path('uploads/newsletter/image/'.$newsletter->image))){
                    unlink(public_path('uploads/newsletter/image/'.$newsletter->image));
                }
                if($newsletter->html_file && file_exists(public_path('uploads/newsletter/html_file/'.$newsletter->html_file))){
                    unlink(public_path('uploads/newsletter/html_file/'.$newsletter->html_file));
                }
                $image_name = \Illuminate\Support\Str::slug($request->title) .'-'. $request->type . '.'.$request->image->extension();
                $path = $request->image->move('uploads/newsletter/image/', $image_name);
                $newsletter->image = $image_name;
                $newsletter->save();
            }
        }
        else
        {
            if ($request->hasFile('html_file')) {
                $newsletter->details = null;
                $newsletter->image = null;
                if($newsletter->html_file && file_exists(public_path('uploads/newsletter/html_file/'.$newsletter->html_file))){
                    unlink(public_path('uploads/newsletter/html_file/'.$newsletter->html_file));
                }
                if($newsletter->image && file_exists(public_path('uploads/newsletter/image/'.$newsletter->image))){
                    unlink(public_path('uploads/newsletter/image/'.$newsletter->image));
                }
                $image_name = \Illuminate\Support\Str::slug($request->title) . '-'. $request->type . '.'.$request->html_file->extension();
                $path = $request->html_file->move('uploads/newsletter/html_file/', $image_name);
                $newsletter->html_file = $image_name;
                $newsletter->save();
            }
        }
        return redirect()->route('newsletters.index')->with('success','Newsletter Saved');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Newsletter $newsletter)
    {
        if($newsletter){

            if($newsletter->image){
                $image = public_path('uploads/newsletter/image/' . $newsletter->image);
                if(file_exists($image)){
                    unlink($image);
                }
            }

            if($newsletter->html_file){
                $html = public_path('uploads/newsletter/html_file/' . $newsletter->html_file);
                if(file_exists($html)){
                    unlink($html);
                }
            }

            if($newsletter->delete()){
                return redirect()->route('newsletters.index')->with('success', 'Newsletter deleted.');
            }else{
                return redirect()->route('newsletters.index')->with('error', 'Error while deleting Newsletter.');
            }

        }else{
            abort();
        }
    }

    public function resend(Newsletter $newsletter)
    {
        if($newsletter->type == 'plain')
        {
            foreach($newsletter->subscriber_group_id as $value)
            {
                $sub_group = SubscriberGroup::find($value);
                // dd($sub_group->subscribers);
                foreach($sub_group->subscribers as $subscriber)
                {
                    Mail::send(new Newsletters($newsletter, $subscriber->email));
                }
            }
        }
        else
        {
            foreach($newsletter->subscriber_group_id as $value)
            {
                $sub_group = SubscriberGroup::find($value);
                // dd($sub_group->subscribers);
                foreach($sub_group->subscribers as $subscriber)
                {
                    $file = file_get_contents(asset('uploads/newsletter/html_file/'. $newsletter->html_file));
                    Mail::to($subscriber->email)->send($file);
                }
            }
        }
        return redirect()->route('newsletters.index')->with('success','Newsletter Resent');
    }
}
