@extends('admin.app')

@section('title')
Edit category
@endsection

@section('content')
<div class="card">
	<form class="form-horizontal" action="{{ route('teamcategories.update', $teamcategory->id) }}" accept-charset="utf-8" method="post" enctype="multipart/form-data">
		{{ method_field('PUT') }}
		{!! csrf_field() !!}
		@include('admin.teamcategory.form')
	</form>
</div>
@endsection