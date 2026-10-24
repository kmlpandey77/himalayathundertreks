@extends('admin.app')

@section('title')
Edit review
@endsection

@section('content')
<div class="card">
	<form class="form-horizontal" action="{{ route('reviews.update', $review->id) }}" accept-charset="utf-8" method="post" enctype="multipart/form-data">
		{{ method_field('PUT') }}
		{!! csrf_field() !!}
		@include('admin.review.form')
	</form>
</div>
@endsection