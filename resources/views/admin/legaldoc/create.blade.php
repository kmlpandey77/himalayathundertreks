@extends('admin.app')

@section('title')
Add Legal docs
@endsection

@section('content')
<div class="card">
	<form class="form-horizontal" action="{{ route('legaldocs.store') }}" accept-charset="utf-8" method="post" enctype="multipart/form-data">
		{!! csrf_field() !!}
		@include('admin.legaldoc.form')
	</form>
</div>
@endsection