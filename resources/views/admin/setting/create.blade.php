@extends('admin.app')

@section('title')
Add Setting
@endsection

@section('content')
<div class="card">
	<form class="form-horizontal" action="{{ route('settings.store') }}" accept-charset="utf-8" method="post" enctype="multipart/form-data">
		{!! csrf_field() !!}
		@include('admin.setting.form')
	</form>
</div>
@endsection