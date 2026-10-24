@extends('admin.app') 
@section('title') Edit Page
@endsection
 
@section('content')

<div class="card">
	<form class="form-horizontal" action="{{ route('pages.update', $page->id) }}" accept-charset="utf-8" method="post">
		{{ method_field('PUT') }} 
		{!! csrf_field() !!}
		@include('admin.page.form')
	</form>
</div>
@endsection