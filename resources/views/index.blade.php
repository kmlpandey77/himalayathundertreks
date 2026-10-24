@extends('layouts.app')

@section('title', $page->m_title)

@section('meta')
<meta content="{{ $page->m_description }}" name="description" />
<meta content="{{ $page->m_keyword }}" name="keywords" />
<meta content="{{ $page->m_title }}" property="og:title" />
<meta content="{{ $page->m_description }}" property="og:description" />
<meta content="{{ asset('images/logo-square.png') }}" property="og:image" />
@endsection

@section('content')
<section class="homeslide">
    <div class="owl-carousel owl-theme" id="homeslide">
        @foreach($slides as $key => $slide)
        <div class="item">
            <div class="overlay">
            </div>
            {{-- First slide is the LCP image: load it immediately; the rest load when they come into view. --}}
            <picture>
                @if(!empty($slide['webp']))
                <source type="image/webp" srcset="{{ $slide['webp_sm'] }} 800w, {{ $slide['webp'] }} 1600w" sizes="100vw">
                @endif
                <img alt="{{ $slide['title'] }}" src="{{ $slide['image_path'] }}" title="{{ $slide['title'] }}"
                    @if($key == 0) fetchpriority="high" @else loading="lazy" @endif />
            </picture>
            <div class="caption">
                <div class="text-wrap">
                    <h4>{{ $slide['title'] }}</h4>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</section>

<section class="welcome">
    <div class="container">
        <h1>
            Welcome to
            <span>
                {{ config('app.name') }}
            </span>
        </h1>
        <div class="welcome-txt">
            <p>
                {{ Str::limit(strip_tags($page->details), 350) }}
            <a href="{{ url('company-information') }}">Read More</a>
            </p>
        </div>
    </div>
</section>
<section class="home_review_wrap bg-white">
    <div class="container">
{{--        <h2 class="section-title" data-title="feature">--}}
{{--            --}}{{-- <span>Customer reviews</span> --}}
{{--            Customer reviews--}}
{{--        </h2>--}}

        <div class="row">

            <div class="col-sm-9">
                <div class="inner-review owl-carousel owl-theme reviews_box" id="reviews_box">
                    @foreach($reviews as $review)
                    <div class="media review">
                        @if ($review->image)
                        <img class="align-self-start mr-4 d-none d-lg-block rounded-circle img-thumbnail" data-src="{{ $review->image_path }}"
                            alt="{{ $review->name }}" title="{{ $review->name }}" width="100">
                        @else
                        <img class="align-self-start mr-4 d-none d-lg-block rounded-circle img-thumbnail"
                            data-src="{{ asset('images/default/user.jpg') }}" alt="{{ $review->name }}" width="100">
                        @endif

                        <div class="media-body">
                            <h5 class="mt-0">{{ $review->title }}</h5>
                            <p class="rating" itemprop="description">
                                @for ($i = 0; $i < $review->rating; $i++)
                                    <i class="fa fa-star active"></i>
                                    @endfor
                                    @for ($k = ($i-1); $k < 4; $k++) <i class="fa fa-star deactive"></i>
                                        @endfor
                            </p>
                            <p>
                                {{ Str::limit(strip_tags($review->details), 600) }}
                            </p>
                            <p class="name">By <i><span itemprop="author">{{ $review->name }} </span>,
                                    <b>{{ $review->country->name }}</b></i></p>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="text-center mt-3">
                    <a href="{{ url('reviews') }}" class="button button-primary button-rounded">View all</a>
                </div>
            </div>
            <div class="col-md-auto">
                <div class="text-center">
                    <div id="TA_selfserveprop575" class="TA_selfserveprop"><ul id="OtOSpIiPP" class="TA_links uJBRtFo"><li id="XMYlEwO" class="UDwQZMYgM78"><a target="_blank" href="https://www.tripadvisor.com/"><img src="https://www.tripadvisor.com/img/cdsi/img2/branding/150_logo-11900-2.png" alt="TripAdvisor"/></a></li></ul></div><script async src="https://www.jscache.com/wejs?wtype=selfserveprop&amp;uniq=575&amp;locationId=8414221&amp;lang=en_US&amp;rating=true&amp;nreviews=4&amp;writereviewlink=true&amp;popIdx=true&amp;iswide=false&amp;border=false&amp;display_version=2" data-loadtrk onload="this.loadtrk=true"></script>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="destination">
    <div class="container">
        <h2 class="section-title">
            <span>BEGIN YOUR ADVENTURE</span>
            Explore a Different way of Travelling
        </h2>

        <div class="row no-gutters">
            @foreach($activies as $activity)
            <div class="col-sm">
                <div class="dest-box image" data-background-image="{{ $activity['image_path'] }}">
                    <div class="text overlay">
                        <h3>
                            {{ $activity['menu_title']?:$activity['title'] }}
                        </h3>
                        <p class="desc">
                            {{ $activity['details'] }}
                        </p>
                        <a class="button button-pill button-primary button-small readmore" href="{{ $activity['url'] }}">
                            Read More
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

@if($best_selling)
<section class="feature-trip bg-white">
    <div class="container">
        <h2 class="section-title">
            <span>Most popular experiences</span>
            Over the years, here is the list of most popular trips
        </h2>
        <div class="row justify-content-center">
            @foreach($best_selling as $package)
            @include('package-card')
            @endforeach
        </div>
    </div>
</section>
@endif

@if($feature_trip)
<section class="feature-trip">
    <div class="container">
        <h2 class="section-title" data-title="feature">
            <span>Beautiful trips with... Special offers</span>
            Featured holiday packages
        </h2>
        <div class="row justify-content-center">
            @foreach($feature_trip as $package)
            @include('package-card')
            @endforeach
        </div>
    </div>
</section>
@endif


@if($blogs && count($blogs))
<section class="travel-blog bg-white">
    <div class="container">
        <h2 class="section-title">
            <span>Explore the</span>
            World of Himalaya Thunder Treks
        </h2>
        <div class="row justify-content-center">
            @foreach ($blogs as $key=>$blog)
            @include('blog.card', ['homeRow' => true, 'headingTag' => 'h3'])
            @endforeach
        </div>
        <div class="text-center">
            <a href="{{ url('blogs') }}" class="button button-primary button-rounded">View all</a>
        </div>
    </div>
</section>
@endif

@endsection
