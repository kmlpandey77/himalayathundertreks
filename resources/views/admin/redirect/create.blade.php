@extends('admin.app')

@section('title')
Add Redirect
@endsection

@section('content')
<div class="card">
	<form class="form-horizontal" action="{{ route('redirects.store') }}" accept-charset="utf-8" method="post" enctype="multipart/form-data">
		{!! csrf_field() !!}
		@include('admin.redirect.form')
	</form>
</div>
@endsection