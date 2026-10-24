@extends('admin.app')

@section('title')
Edit activity
@endsection

@section('content')
<div class="card">
	<form class="form-horizontal" action="{{ route('activities.update', $activity->id) }}" accept-charset="utf-8" method="post" enctype="multipart/form-data">
		{{ method_field('PUT') }}
		{!! csrf_field() !!}
		@include('admin.activity.form')
	</form>
</div>
@endsection