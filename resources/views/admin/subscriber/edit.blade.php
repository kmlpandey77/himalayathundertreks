@extends('admin.app')

@section('title')
Edit Subscriber
@endsection

@section('content')
<div class="card">
	<form class="form-horizontal" action="{{ route('subscribers.update', [$subscriber->id] + $_GET) }}" accept-charset="utf-8" method="post" enctype="multipart/form-data">
		{{ method_field('PUT') }}
		{!! csrf_field() !!}
		@include('admin.subscriber.form')
	</form>
</div>
@endsection