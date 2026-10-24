@extends('admin.app')

@section('title')
Add Page
@endsection

@section('content')

<div class="card">
	<form class="form-horizontal" action="{{ route('pages.store') }}" accept-charset="utf-8" method="post">
		{!! csrf_field() !!}
		@include('admin.page.form')
	</form>
</div>
@endsection