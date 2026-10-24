@extends('admin.app')

@section('title')
Add News
@endsection

@section('content')
<div class="card">
	<form class="form-horizontal" action="{{ route('news.store') }}" accept-charset="utf-8" method="post" enctype="multipart/form-data">
		{!! csrf_field() !!}
		@include('admin.news.form')
	</form>
</div>
@endsection