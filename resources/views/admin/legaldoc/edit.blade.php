@extends('admin.app')

@section('title')
Edit Legal doc
@endsection

@section('content')
<div class="card">
	<form class="form-horizontal" action="{{ route('legaldocs.update', $legaldoc->id) }}" accept-charset="utf-8" method="post" enctype="multipart/form-data">
		{{ method_field('PUT') }}
		{!! csrf_field() !!}
		@include('admin.legaldoc.form')
	</form>
</div>
@endsection