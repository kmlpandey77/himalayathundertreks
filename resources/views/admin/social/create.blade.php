@extends('admin.app')

@section('title')
Add Social link
@endsection

@section('content')
<div class="card">
	<form class="form-horizontal" action="{{ route('socials.store') }}" accept-charset="utf-8" method="post" enctype="multipart/form-data">
		{!! csrf_field() !!}
		@include('admin.social.form')
	</form>
</div>
@endsection