@component('mail::message')
Date: <b>{{ date('F d, Y') }} </b>  
IP Address: <b>*{{ request()->ip() }}*</b> 
Trip Name: {{ $request->trip_name }}
<div class="spacer"></div>
<div class="spacer"></div>
<br>



**Name:** {{ $request->text_fname }} {{ $request->text_lname }}  
**Email:** {{ $request->text_email }}  
**Phone:** {{ $request->text_phone }}  
**Country:** {{ $request->sel_country }}  
**Total Travellers**   
**Number of child traveller:** {{ $request->number_of_child_traveller }}  
**Number of adult traveller:** {{ $request->number_of_adult_traveller }}  
**Arrival date:** {{ $request->check_in }}  
**Departure date:** {{ $request->check_out }}  
**Airport pickup?:** {{ $request->pickup }}  

**Message:**  
"{!! nl2br($request->texta_message) !!}"


<br>
<br>
<br>

<div class="spacer"></div>
<div class="spacer"></div>

Thanks,<br>
{{ config('app.name') }}
@endcomponent