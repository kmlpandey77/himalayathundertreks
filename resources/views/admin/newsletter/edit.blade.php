@extends('admin.app')

@section('title')
Edit Newsletter
@endsection

@section('content')
<div class="card">
	<form class="form-horizontal" action="{{ route('newsletters.update', $newsletter->id) }}" accept-charset="utf-8" method="post" enctype="multipart/form-data">
		{{ method_field('PUT') }}
		{!! csrf_field() !!}
		@include('admin.newsletter.form')
	</form>
</div>
@endsection