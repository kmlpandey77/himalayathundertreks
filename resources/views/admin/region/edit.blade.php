@extends('admin.app')

@section('title')
Edit region
@endsection

@section('content')
<div class="card">
	<form class="form-horizontal" action="{{ route('regions.update', $region->id) }}" accept-charset="utf-8" method="post" enctype="multipart/form-data">
		{{ method_field('PUT') }}
		{!! csrf_field() !!}
		@include('admin.region.form')
	</form>
</div>
@endsection