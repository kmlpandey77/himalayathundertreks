@extends('admin.app') 
@section('title') Edit Tag
@endsection
 
@section('content')

<div class="card">
	<form class="form-horizontal" action="{{ route('tags.update', $tag->id) }}" accept-charset="utf-8" method="post">
		{{ method_field('PUT') }}
		{!! csrf_field() !!}
		@include('admin.tag.form')
	</form>
</div>
@endsection