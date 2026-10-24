@extends('admin.app')

@section('title')
Edit slide
@endsection

@section('content')
<div class="card">
	<form class="form-horizontal" action="{{ route('regionslides.update', $slide->id) }}" accept-charset="utf-8" method="post" enctype="multipart/form-data">
		{{ method_field('PUT') }}
		{!! csrf_field() !!}
		@include('admin.regionslide.form')
	</form>
</div>
@endsection