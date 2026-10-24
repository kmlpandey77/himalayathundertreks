@extends('admin.app') 
@section('title') Edit Package
@endsection
 
@section('content')

<div class="card">
	<form class="form-horizontal" action="{!! route('packages.update', [$package->id] + $_GET) !!}" accept-charset="utf-8" method="post"
	 enctype="multipart/form-data">
		{{ method_field('PUT') }} 
		{!! csrf_field() !!}
		@include('admin.package.form')
	</form>
</div>
@endsection