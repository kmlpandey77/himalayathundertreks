@component('mail::message')
Date: <b>{{ date('F d, Y') }} </b>  
IP Address: <b>*{{ request()->ip() }}*</b>  
@if($request->inquiry_page)
Trip Name: {{ $request->inquiry_page }}
@endif
<div class="spacer"></div>
<div class="spacer"></div>
<br>



**Name:** {{ $request->full_name }}  
**Email:** {{ $request->email }}  
**Phone:** {{ $request->phone }}    
**Country:** {{ $request->country }}   
**Travel Date:** {{ $request->travel_date }}   
**Group Size:** {{ $request->group_size }}   


**Message:**  
"{!! nl2br($request->message) !!}"


<br>
<br>
<br>

<div class="spacer"></div>
<div class="spacer"></div>

Thanks,<br>
{{ config('app.name') }}
@endcomponent