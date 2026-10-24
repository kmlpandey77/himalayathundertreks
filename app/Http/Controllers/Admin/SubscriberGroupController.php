<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\SubscriberGroup;

class SubscriberGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['subscriber_groups'] = SubscriberGroup::paginate(10);
        return view('admin.subscriber_group.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.subscriber_group.create');
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
        ]);

        $data = array(
            'title' => $request->title,
            'details' => $request->details,
        );
        SubscriberGroup::create($data);
        return redirect()->route('subscriber-groups.index')->with('success','Subscriber Group Added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(SubscriberGroup $subscriber_group)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(SubscriberGroup $subscriber_group)
    {
        return view('admin.subscriber_group.edit', compact('subscriber_group'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SubscriberGroup $subscriber_group)
    {
        $this->validate($request, [
            'title' => 'required',
        ]);

        $data = array(
            'title' => $request->title,
            'details' => $request->details,
        );
        SubscriberGroup::where('id', $subscriber_group->id)->update($data);
        return redirect()->route('subscriber-groups.index')->with('success','Subscriber Group Saved');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(SubscriberGroup $subscriber_group)
    {
        if($subscriber_group){

            if($subscriber_group->delete()){
                return redirect()->route('subscriber-groups.index')->with('success', 'Subscriber Group deleted.');
            }else{
                return redirect()->route('subscriber-groups.index')->with('error', 'Error while deleting Subscriber Group.');
            }

        }else{
            abort();
        }
    }
}
