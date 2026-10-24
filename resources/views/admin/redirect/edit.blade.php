@extends('admin.app')

@section('title')
Edit redirect
@endsection

@section('content')
<div class="card">
	<form class="form-horizontal" action="{{ route('redirects.update', $redirect->id) }}" accept-charset="utf-8" method="post" enctype="multipart/form-data">
		{{ method_field('PUT') }}
		{!! csrf_field() !!}
		@include('admin.redirect.form')
	</form>
</div>
@endsection