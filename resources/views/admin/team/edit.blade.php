@extends('admin.app')

@section('title')
Edit team
@endsection

@section('content')
<div class="card">
	<form class="form-horizontal" action="{{ route('teams.update', $team->id) }}" accept-charset="utf-8" method="post" enctype="multipart/form-data">
		{{ method_field('PUT') }}
		{!! csrf_field() !!}
		@include('admin.team.form')
	</form>
</div>
@endsection