@component('mail::message')
Date: <b>{{ date('F d, Y') }} </b>  
IP Address: <b>*{{ request()->ip() }}*</b>  
Trip Name: {{ $request->package }}
<div class="spacer"></div>
<div class="spacer"></div>
<br>


**Name:** {{ $request->full_name }}  
**Email:** {{ $request->email }}  
**Phone:** {{ $request->phone }}  
**Country:** {{ $request->country }}  
**Number of Traveller:** {{ $request->number_of_traveller }}  
**Duration:** {{ $request->duration }}  
**Hotel Category:** {{ $request->hotel_category }}  
**Flight Destination:** {{ $request->flight_destination }}  

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
