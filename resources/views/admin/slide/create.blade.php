@extends('admin.app')

@section('title')
Add slide
@endsection

@section('content')
<div class="card">
	<form class="form-horizontal" action="{{ route('slides.store') }}" accept-charset="utf-8" method="post" enctype="multipart/form-data">
		{!! csrf_field() !!}
		@include('admin.slide.form')
	</form>
</div>
@endsection