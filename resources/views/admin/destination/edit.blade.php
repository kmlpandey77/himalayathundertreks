@extends('admin.app')

@section('title')
Edit destination
@endsection

@section('content')
<div class="card">
	<form class="form-horizontal" action="{{ route('destinations.update', $destination->id) }}" accept-charset="utf-8" method="post" enctype="multipart/form-data">
		{{ method_field('PUT') }}
		{!! csrf_field() !!}
		@include('admin.destination.form')
	</form>
</div>
@endsection