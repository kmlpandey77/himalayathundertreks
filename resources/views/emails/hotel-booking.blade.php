<p>
	Date: <b>{{ date('F d, Y') }} </b>  <br>
	IP Address: <b>*{{ request()->ip() }}*</b> <br>
	Hotel Name: {{ $request->hotel_name }}
</p>

<p>
	<b>Name:</b> {{ $request->name }}  <br>
	<b>Email:</b> {{ $request->email }}  <br>
	<b>Phone:</b> {{ $request->phone }}  <br>
	<b>Group Size:</b> {{ $request->group_size }}  <br>
	<b>Country:</b> {{ $request->country }}  <br>
	<b>Room Category:</b> {{ $request->room_category }}  <br>
	<b>No of Room:</b> {{ $request->no_of_room }}  <br>
	<b>First Visit Check In:</b> {{ $request->first_check_in ? $request->first_check_in : '-' }}  <br>
	<b>First Visit Check Out:</b> {{ $request->first_check_out ? $request->first_check_out : '-' }}  <br>
	<b>Second Visit Check In:</b> {{ $request->second_check_in ? $request->second_check_in : '-'  }}  <br>
	<b>Second Visit Check Out:</b> {{ $request->second_check_out ? $request->second_check_out : '-'  }}  <br>
	<b>Meal Plan:</b> {{ $request->meal_plan ? $request->meal_plan : '-'  }}  <br>
</p>

<p>
	<b>Message:</b> <br>
	"{!! nl2br($request->message) !!}"
</p>


