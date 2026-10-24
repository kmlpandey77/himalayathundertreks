@extends('admin.app')

@section('title')
Add Team
@endsection

@section('content')
<div class="card">
	<form class="form-horizontal" action="{{ route('teams.store') }}" accept-charset="utf-8" method="post" enctype="multipart/form-data">
		{!! csrf_field() !!}
		@include('admin.team.form')
	</form>
</div>
@endsection