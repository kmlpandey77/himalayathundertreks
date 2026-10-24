@extends('admin.app')

@section('title')
Add Review
@endsection

@section('content')
<div class="card">
	<form class="form-horizontal" action="{{ route('reviews.store') }}" accept-charset="utf-8" method="post" enctype="multipart/form-data">
		{!! csrf_field() !!}
		@include('admin.review.form')
	</form>
</div>
@endsection