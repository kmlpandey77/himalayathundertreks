@extends('admin.app')

@section('title')
Add Category
@endsection

@section('content')
<div class="card">
	<form class="form-horizontal" action="{{ route('teamcategories.store') }}" accept-charset="utf-8" method="post" enctype="multipart/form-data">
		{!! csrf_field() !!}
		@include('admin.teamcategory.form')
	</form>
</div>
@endsection