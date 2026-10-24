@extends('admin.app')

@section('title')
Add Destination
@endsection

@section('content')
<div class="card">
	<form class="form-horizontal" action="{{ route('destinations.store') }}" accept-charset="utf-8" method="post" enctype="multipart/form-data">
		{!! csrf_field() !!}
		@include('admin.destination.form')
	</form>
</div>
@endsection