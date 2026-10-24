@extends('admin.app')

@section('title')
Add Associate
@endsection

@section('content')
<div class="card">
	<form class="form-horizontal" action="{{ route('associates.store') }}" accept-charset="utf-8" method="post" enctype="multipart/form-data">
		{!! csrf_field() !!}
		@include('admin.associate.form')
	</form>
</div>
@endsection
