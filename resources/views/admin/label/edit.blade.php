@extends('admin.app')

@section('title')
Edit label
@endsection

@section('content')
<div class="card">
	<form class="form-horizontal" action="{{ route('labels.update', $label->id) }}" accept-charset="utf-8" method="post" enctype="multipart/form-data">
		{{ method_field('PUT') }}
		{!! csrf_field() !!}
		@include('admin.label.form')
	</form>
</div>
@endsection