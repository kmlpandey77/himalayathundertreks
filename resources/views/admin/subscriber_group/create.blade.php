@extends('admin.app')

@section('title')
Add Subscriber Group
@endsection

@section('content')
<div class="card">
	<form class="form-horizontal" action="{{ route('subscriber-groups.store') }}" accept-charset="utf-8" method="post" enctype="multipart/form-data">
		{!! csrf_field() !!}
		@include('admin.subscriber_group.form')
	</form>
</div>
@endsection