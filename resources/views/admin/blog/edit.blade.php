@extends('admin.app')

@section('title')
Edit Blog
@endsection

@section('content')
<div class="card">
	<form class="form-horizontal" action="{{ route('blogs.update', $blog->id) }}" accept-charset="utf-8" method="post" enctype="multipart/form-data">
		{{ method_field('PUT') }}
		{!! csrf_field() !!}
		@include('admin.blog.form')
	</form>
</div>
@endsection