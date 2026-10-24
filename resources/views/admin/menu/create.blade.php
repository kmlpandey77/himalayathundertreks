@extends('admin.app')

@section('title')
Add Menu
@endsection

@section('content')

<div class="card">
	<form class="form-horizontal" action="{{ route('menus.store') }}" accept-charset="utf-8" method="post">
		{!! csrf_field() !!}
		@include('admin.menu.form')
	</form>
</div>
@endsection