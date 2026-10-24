@extends('admin.app')

@section('title')
Edit Subscriber Group
@endsection

@section('content')
<div class="card">
	<form class="form-horizontal" action="{{ route('subscriber-groups.update', $subscriber_group->id) }}" accept-charset="utf-8" method="post" enctype="multipart/form-data">
		{{ method_field('PUT') }}
		{!! csrf_field() !!}
		@include('admin.subscriber_group.form')
	</form>
</div>
@endsection