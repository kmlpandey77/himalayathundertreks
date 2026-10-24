@extends('layouts.app')
@section('title', $tag->m_title)

@section('meta')
<meta name="description" content="{{ $tag->m_description }}">
<meta name="keywords" content="{{ $tag->m_keyword }}">
<meta property="og:description" content="{{ $tag->m_description }}" />
@endsection

@section('content')

<section class="breadcrubwapper">
    <div class="container">
        {!! new Breadcrumb($tag) !!}
    </div>
</section>

<section class="content gray-bg">
    <div class="container">


        <div class="card-list"">

            <div class="inner-heading"><h3> {{ $tag->title }} Package</h3></div>
            @if ($tag->packages)

                <div class="row">

                    @foreach ($tag->packages as $package)
                    @include('package-card')
                    @endforeach
            @endif

            </div>
        </div>

    </div>
</section>

{{-- <section class="content {{ $region->slug }}">
    <div class="container">

        {!! new Breadcrumb($region) !!}

        <div class="row">
            <div class="col-sm-12">
                <div class="content-left">

                    <h1>{{ $region->title }}</h1>

                    <div class="inner-box">
                        {!! $region->details !!}
                    </div>

                </div>

                @if ($region->packages)

                <div class="card-list">

                    <div class="inner-heading"><h3>Packages</h3></div>

                    <div class="row">

                        @foreach ($region->packages as $package)
                        @include('package-card')
                        @endforeach

                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</section> --}}
@endsection

@section('script')
<script>
    $(document).ready(function(){
        $("#innerslide").owlCarousel({
          loop:true,
          nav:false,
          items:1,
          dots: false,
          autoplay:true,
        });
    });

</script>
@endsection