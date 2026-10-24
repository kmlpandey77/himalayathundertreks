@component('vendor.mail.html.message')
<p>
	Date: <b>{{ date('F d, Y') }} </b>  <br>
	IP Address: <b>{{ request()->ip() }}</b>
</p>

<p>
	<b>Name:</b> {{ $request->name }} <br>
	<b>Email:</b> {{ $request->email }} <br>
	<b>Phone:</b> {{ $request->phone }} <br>
</p>


<p>
	<b>Message</b> <br>
	"{!! nl2br(e($request->message)) !!}"
</p>

@endcomponent