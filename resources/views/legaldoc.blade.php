@extends('layouts.app')

@section('title')
{{ $page->title }}@endsection

@section('meta')
<meta name="description" content="{{ $page->title }}" >
<meta name="keywords" content="{{ $page->title }}" >
@endsection

@section('content')
<section class="breadcrumb-wrap">
    <div class="container">
        {!! new Breadcrumb($page) !!}
    </div>
</section>
<section class="content gray-bg {{ $page->slug }}">
    <div class="container">

		<section class="overview">
			<h1>
				{{ $page->title }}
			</h1>
			<hr>
			<div class="legaldocs">
				<div class="grid" id="lightgallery">
					@foreach ($legaldocs as $legaldoc)
					<a class="col-sm-3 grid-item mb-3" href="{{ asset('uploads/legaldocs/' . $legaldoc->image) }}" title="{{ $legaldoc->name }}">
						<img src="{{ $legaldoc->thumb_image }}" alt="{{ $legaldoc->name }}" class="img-responsive img-thumbnail">
					</a>
					@endforeach
				</div>
			</div>
		</section>

    </div>
</section>
@endsection

@section('script')

<script src="{{ asset('js/masonry.pkgd.min.js') }}"></script>
<script src="{{ asset('vendors/lightgallery/lightgallery.min.js') }}"></script>
<script src="{{ asset('vendors/lightgallery/lg-zoom.js') }}"></script>

<link rel="stylesheet" href="{{ asset('vendors/lightgallery/lightgallery.min.css') }}">

<script>
	$(document).ready(function() {
		lightGallery(document.getElementById('lightgallery'),{
			download:false,
			zoom: true,
		});
		$('.grid').masonry({
			itemSelector: '.grid-item',
			percentPosition: true
		});
	});
</script>

@endsection
