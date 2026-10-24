@extends('admin.app')

@section('title')
Edit associate
@endsection

@section('content')
<div class="card">
	<form class="form-horizontal" action="{{ route('associates.update', $associate->id) }}" accept-charset="utf-8" method="post" enctype="multipart/form-data">
		{{ method_field('PUT') }}
		{!! csrf_field() !!}
		@include('admin.associate.form')
	</form>
</div>
@endsection
