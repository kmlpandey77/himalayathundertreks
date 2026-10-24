@extends('admin.app')

@section('title')
Edit slide
@endsection

@section('content')
<div class="card">
	<form class="form-horizontal" action="{{ route('slides.update', $slide->id) }}" accept-charset="utf-8" method="post" enctype="multipart/form-data">
		{{ method_field('PUT') }}
		{!! csrf_field() !!}
		@include('admin.slide.form')
	</form>
</div>
@endsection