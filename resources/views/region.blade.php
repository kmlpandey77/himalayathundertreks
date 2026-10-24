@extends('layouts.app')
@section('title') {{ $region->m_title }}
@endsection

@section('meta')
<meta name="description" content="{{ $region->m_description }}">
<meta name="keywords" content="{{ $region->m_keyword }}">
<meta property="og:description" content="{{ $region->m_description }}" />
@endsection

@section('content')

<section class="innerslide">
    @if($region->slides()->count() > 0)
    <div class="owl-carousel" id="innerslide">
        @foreach ($region->slides as $key => $slide)
        <div class="item">
            <img src="{{ $slide->image_path }}" alt="{{ $slide->title }}" title="{{ $slide->title }}">
        </div>
        @endforeach
    </div>
    @endif

    <div class="innerslide_title">
        <div class="container">
            <div class="row">
                <div class="col">
                    <h1 itemprop="name">{{ $region->title }}</h1>
                </div>                
            </div>
        </div>
        <section class="breadcrumb-wrap trip">
            <div class="container">
                {!! new Breadcrumb($region) !!}
            </div>
        </section>
    </div>
</section>

{{-- <section class="breadcrumb-wrap">
    <div class="container">
        {!! new Breadcrumb($region) !!}
    </div>
</section> --}}

<section class="content {{ $region->slug }}">
    <div class="container">
        {{-- <h1>
            {{ $region->title }}
        </h1> --}}

        <section class="overview">
            {!! $region->details !!}
        </section>

        @if ($region->packages)

        <div class="card-list">

            <div class="inner-heading"><h3>Package</h3></div>

            <div class="row">

                @foreach ($region->packages as $package)
                @include('package-card')
                @endforeach

            </div>
        </div>
        @endif

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