@extends('admin.app')

@section('title')
Edit Album
@endsection

@section('content')
<div class="card">
	<form class="form-horizontal" action="{{ route('albums.update', $album->id) }}" accept-charset="utf-8" method="post" enctype="multipart/form-data">
		{{ method_field('PUT') }}
		{!! csrf_field() !!}
		@include('admin.photo_album.form')
	</form>
</div>
@endsection