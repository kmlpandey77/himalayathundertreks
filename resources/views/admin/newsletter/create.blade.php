@extends('admin.app')

@section('title')
Add Newsletter
@endsection

@section('content')
<div class="card">
	<form class="form-horizontal" action="{{ route('newsletters.store') }}" accept-charset="utf-8" method="post" enctype="multipart/form-data">
		{!! csrf_field() !!}
		@include('admin.newsletter.form')
	</form>
</div>
@endsection