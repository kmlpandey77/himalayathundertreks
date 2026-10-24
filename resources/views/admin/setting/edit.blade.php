@extends('admin.app')

@section('title')
Edit Setting
@endsection

@section('content')
<div class="card">
	<form class="form-horizontal" action="{{ route('settings.update', $setting->id) }}" accept-charset="utf-8" method="post" enctype="multipart/form-data">
		{{ method_field('PUT') }}
		{!! csrf_field() !!}
		@include('admin.setting.form')
	</form>
</div>
@endsection