@component('mail::message')
Date: <b>{{ date('F d, Y') }} </b> <br>
IP Address: <b>*{{ request()->ip() }}*</b><br>
Trip Name: {{ $request->package }}<br>
<div class="spacer"></div>
<div class="spacer"></div>
<br>

<p>
	<b>Name:</b> {{ $request->full_name }}  <br>
	<b>Email:</b> {{ $request->email }}  <br>
	<b>Phone:</b> {{ $request->phone }}  <br>
	<b>Country:</b> {{ $request->country }}  <br>
	<b>Number of Traveller:</b> {{ $request->number_of_traveller }}  <br>
	<b>Duration:</b> {{ $request->duration }}  <br>
	<b>Hotel Category:</b> {{ $request->hotel_category }}  <br>
	<b>Flight Destination:</b> {{ $request->flight_destination }}<br>
</p>

<br>

**Message:**<br>
"{!! nl2br($request->message) !!}"


<br>
<br>
<br>

<div class="spacer"></div>
<div class="spacer"></div>

Thanks,<br>
{{ config('app.name') }}
@endcomponent
