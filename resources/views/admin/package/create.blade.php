@extends('admin.app')

@section('title')
Add Package
@endsection

@section('content')

<div class="card">
	<form class="form-horizontal" action="{!! route('packages.store', $_GET) !!}" accept-charset="utf-8" method="post" enctype="multipart/form-data">
		{!! csrf_field() !!}
		@include('admin.package.form')		
	</form>
</div>
@endsection