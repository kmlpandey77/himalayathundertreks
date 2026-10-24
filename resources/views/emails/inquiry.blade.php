<p>
	Date: <b>{{ date('F d, Y') }} </b>  <br>
	IP Address: <b>{{ request()->ip() }}</b>
</p>

<p>
	<b>Name:</b> {{ $request->full_name }} <br>
	<b>Email:</b> {{ $request->email }} <br>
	<b>Phone:</b> {{ $request->phone }} <br>
	<b>Country:</b> {{ $request->country }}
</p>


<p>
	<b>Message</b> <br>
	"{!! nl2br($request->message) !!}"
</p>