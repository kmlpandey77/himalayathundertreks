<?php

namespace App\Http\Controllers\Admin;

use App\Subscriber;
use App\SubscriberGroup;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SubcriberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $subscribers = Subscriber::paginate(5);
        $subscribers = Subscriber::query();
        if($request->keyword){
            $like = '%' . $request->keyword . '%';
            $subscribers->orWhere('email', 'like', $like);
        }
        $subscribers = $subscribers->paginate(5);
        return view('admin.subscriber.index', compact('subscribers'));
    }

    public function create()
    {
        $subscriber_groups = SubscriberGroup::all();
        return view('admin.subscriber.create', compact('subscriber_groups'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
        ]);

        $subscriber = new Subscriber;
        $subscriber->name = $request->name;
        $subscriber->email = $request->email;
        $subscriber->phone = $request->phone;
        $subscriber->save();

        if($request->subscriber_groups){
            $subscriber_groups = SubscriberGroup::find($request->subscriber_groups);
            $subscriber->subscriber_groups()->sync($subscriber_groups);
        }
        return redirect()->route('subscribers.index')->with('success', 'Subscriber Added.');
    }

    public function edit(Subscriber $subscriber)
    {
        $subscriber_groups = SubscriberGroup::all();
        return view('admin.subscriber.edit', compact('subscriber', 'subscriber_groups'));
    }

    public function update(Request $request, Subscriber $subscriber)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
        ]);

        $subscriber->name = $request->name;
        $subscriber->email = $request->email;
        $subscriber->phone = $request->phone;
        $subscriber->save();

        if($request->subscriber_groups){
            $subscriber_groups = SubscriberGroup::find($request->subscriber_groups);
            $subscriber->subscriber_groups()->sync($subscriber_groups);
        }
        else
        {
            $subscriber->subscriber_groups()->detach();            
        }
        return redirect()->route('subscribers.index', $_GET)->with('success', 'Subscriber Saved.');
    }

    public function destroy(Subscriber $subscriber)
    {
        if($subscriber){

            $subscriber->subscriber_groups()->detach();
            $subscriber->delete();
            return redirect()->route('subscribers.index', $_GET)->with('success', 'Subscriber Deleted.');
        }else{
            return redirect()->route('subscribers.index', $_GET)->with('error', 'Error while deleting Subscriber.');
        }
    }
}
