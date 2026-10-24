@extends('admin.app')

@section('title')
Add Tag
@endsection

@section('content')

<div class="card">
	<form class="form-horizontal" action="{{ route('tags.store') }}" accept-charset="utf-8" method="post">
		{!! csrf_field() !!}
		@include('admin.tag.form')
	</form>
</div>
@endsection