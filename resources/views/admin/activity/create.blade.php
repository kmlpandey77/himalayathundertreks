@extends('admin.app')

@section('title')
Add Activity
@endsection

@section('content')

<div class="card">
	<form class="form-horizontal" action="{{ route('activities.store') }}" accept-charset="utf-8" method="post" enctype="multipart/form-data">
		{!! csrf_field() !!}
		@include('admin.activity.form')
	</form>
</div>
@endsection