@extends('admin.app')

@section('title')
Add slide
@endsection

@section('content')
<div class="card">
	<form class="form-horizontal" action="{{ route('regionslides.store', $region) }}" accept-charset="utf-8" method="post" enctype="multipart/form-data">
		{!! csrf_field() !!}
		<input type="hidden" value="{{ $region }}" name="trip">
		@include('admin.regionslide.form')
	</form>
</div>
@endsection