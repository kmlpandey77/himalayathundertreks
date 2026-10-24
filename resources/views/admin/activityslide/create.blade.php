@extends('admin.app')

@section('title')
Add slide
@endsection

@section('content')
<div class="card">
	<form class="form-horizontal" action="{{ route('activityslides.store', $activity) }}" accept-charset="utf-8" method="post" enctype="multipart/form-data">
		{!! csrf_field() !!}
		<input type="hidden" value="{{ $activity }}" name="trip">
		@include('admin.activityslide.form')
	</form>
</div>
@endsection