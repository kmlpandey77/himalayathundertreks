@extends('layouts.app')

@section('title', $album->title . ' - Photo Gallery - ' .config('app.name') )

@section('content')
<section class="breadcrubwapper">
    <div class="container">
        {!! new Breadcrumb($album) !!}
    </div>
</section>
<section class="content gray-bg">
    <div class="container">
        <section class="overview">
            <h1>
                {{ $album->title }} - Photo Gallery
            </h1>

            @if($album->photos()->count())
            <div class="row" id="lightgallery">
                @foreach($album->photos as $photo)
                <a class="col-sm-3" href="{{ asset('uploads/photo/' . $photo->image) }}" title="{{ $photo->caption }}">
                    <img src="{{ $photo->image() }}" alt="{{ $photo->name }}" class="img-responsive img-thumbnail">
                </a>
                @endforeach
            </div>
            @endif

        </section>
    </div>
</section>
@endsection

@section('script')
<link rel="stylesheet" href="{{ asset('vendors/lightgallery/lightgallery.min.css') }}">
<script src="{{ asset('vendors/lightgallery/lightgallery.min.js') }}"></script>
<script src="{{ asset('vendors/lightgallery/lg-zoom.js') }}"></script>
<script>
    $(document).ready(function() {
        lightGallery(document.getElementById('lightgallery'),{
            download:false,
            zoom: true,
        });
    });
</script>
@endsection
