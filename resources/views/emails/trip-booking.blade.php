@component('mail::message')
Date: <b>{{ date('F d, Y') }} </b> <br>
IP Address: <b>*{{ request()->ip() }}*</b><br>
Trip Name: {{ $request->trip_name }}<br>
<div class="spacer"></div>
<div class="spacer"></div>
<br>



**Name:** {{ $request->text_fname }} {{ $request->text_lname }}<br>
**Email:** {{ $request->text_email }}<br>
**Phone:** {{ $request->text_phone }}<br>
**Country:** {{ $request->sel_country }}<br><br>
**Total Travellers**<br>
*Number of child traveller:* {{ $request->number_of_child_traveller }}<br>
*Number of adult traveller:* {{ $request->number_of_adult_traveller }}<br>

**Arrival date:** {{ $request->check_in }}<br>
**Departure date:** {{ $request->check_out }}<br>
**Airport pickup?:** {{ $request->pickup }}<br>
<br>
**Message:**<br>
"{!! nl2br($request->texta_message) !!}"


<br>
<br>
<br>

<div class="spacer"></div>
<div class="spacer"></div>

Thanks,<br>
{{ config('app.name') }}
@endcomponent