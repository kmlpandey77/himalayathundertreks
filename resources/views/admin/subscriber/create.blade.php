@extends('admin.app')

@section('title')
Add Subscriber
@endsection

@section('content')
<div class="card">
	<form class="form-horizontal" action="{{ route('subscribers.store') }}" accept-charset="utf-8" method="post" enctype="multipart/form-data">
		{!! csrf_field() !!}
		@include('admin.subscriber.form')
	</form>
</div>
@endsection