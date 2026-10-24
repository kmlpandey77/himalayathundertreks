@extends('admin.app')

@section('title')
Edit social link
@endsection

@section('content')
<div class="card">
	<form class="form-horizontal" action="{{ route('socials.update', $social->id) }}" accept-charset="utf-8" method="post" enctype="multipart/form-data">
		{{ method_field('PUT') }}
		{!! csrf_field() !!}
		@include('admin.social.form')
	</form>
</div>
@endsection