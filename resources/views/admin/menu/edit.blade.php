@extends('admin.app') 
@section('title') Edit Menu
@endsection
 
@section('content')

<div class="card">
	<form class="form-horizontal" action="{{ route('menus.update', $menu->id) }}" accept-charset="utf-8" method="post">
		{{ method_field('PUT') }}
		{!! csrf_field() !!}
		@include('admin.menu.form')
	</form>
</div>
@endsection