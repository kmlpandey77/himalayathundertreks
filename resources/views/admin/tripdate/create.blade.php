@extends('admin.app')

@section('title')
Add Date
@endsection

@section('content')
<div class="card">
	<form class="form-horizontal" action="{{ route('tripdates.store', $trip) }}" accept-charset="utf-8" method="post" enctype="multipart/form-data">
		{!! csrf_field() !!}
		@include('admin.tripdate.form')
	</form>
</div>
@endsection