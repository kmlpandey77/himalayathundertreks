@extends('admin.app')

@section('title')
Edit date
@endsection

@section('content')
<div class="card">
	<form class="form-horizontal" action="{{ route('tripdates.update', $date->id) }}" accept-charset="utf-8" method="post" enctype="multipart/form-data">
		{{ method_field('PUT') }}
		{!! csrf_field() !!}
		@include('admin.tripdate.form')
	</form>
</div>
@endsection