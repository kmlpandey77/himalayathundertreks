@extends('admin.app')

@section('title')
Edit News
@endsection

@section('content')
<div class="card">
	<form class="form-horizontal" action="{{ route('news.update', $news->id) }}" accept-charset="utf-8" method="post" enctype="multipart/form-data">
		{{ method_field('PUT') }}
		{!! csrf_field() !!}
		@include('admin.news.form')
	</form>
</div>
@endsection