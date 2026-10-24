@extends('admin.app')

@section('title')
Add slide
@endsection

@section('content')
<div class="card">
	<form class="form-horizontal" action="{{ route('tripslides.store', $trip) }}" accept-charset="utf-8" method="post" enctype="multipart/form-data">
		{!! csrf_field() !!}
		<input type="hidden" value="{{ $trip }}" name="trip">
		@include('admin.tripslide.form')
	</form>
</div>
@endsection