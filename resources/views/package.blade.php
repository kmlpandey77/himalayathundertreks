@extends('layouts.app', ['inquiry_page' => $package->title])
@section('title') {{ $package->m_title }}
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('stylesheets/trip-gallery.css') }}?v={{ filemtime(public_path('stylesheets/trip-gallery.css')) }}">
@endpush

@section('schema')
@include('seo.trip', ['package' => $package])
@endsection

@section('meta')

<meta name="description" content="{{ $package->m_description }}">
<meta name="keywords" content="{{ $package->m_keyword }}">

<meta property="og:title" content="{{ $package->title }}" />
<meta property="og:description" content="{{ Str::limit(strip_tags($package->details),120) }}" />
@foreach ($package->slides as $key => $slide)
<meta property="og:image" content="{{ asset('uploads/slide/' . $slide->image) }}" />
@endforeach

@endsection

@section('content')
<section class="content trip">



    <section class="innerslide innerslide--grid">
        @if($package->slides->count() > 0)
        @php($gallerySlides = $package->slides->take(5))
        <div class="trip-gallery trip-gallery--{{ $gallerySlides->count() }}">
            @foreach ($gallerySlides as $key => $slide)
            <a href="{{ $slide->image_path }}" class="trip-gallery__tile" data-gallery-index="{{ $key }}"
                aria-label="View photo {{ $key + 1 }} of {{ $package->slides->count() }}: {{ $slide->title }}">
                {{-- First tile is the LCP image: load it immediately; the rest lazy-load. --}}
                <picture>
                    @if($webp = $slide->webp('1600x600'))
                    <source type="image/webp" srcset="{{ $slide->webp('800x300') }} 800w, {{ $webp }} 1600w"
                        sizes="{{ $key == 0 ? '(min-width: 768px) 50vw, 100vw' : '25vw' }}">
                    @endif
                    <img src="{{ $slide->image_path }}" alt="{{ $slide->title }}" title="{{ $slide->title }}"
                        @if($key == 0) fetchpriority="high" @else loading="lazy" @endif>
                </picture>
                @if($loop->last && $package->slides->count() > $gallerySlides->count())
                <span class="trip-gallery__more">+{{ $package->slides->count() - $gallerySlides->count() }} photos</span>
                @endif
            </a>
            @endforeach
            <button type="button" class="trip-gallery__all" data-gallery-index="0">
                <i class="far fa-images"></i> View all {{ $package->slides->count() }} photos
            </button>
        </div>
        @endif

        <div class="innerslide_title">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <h1>{{ $package->title }}</h1>
                    </div>
                    <div class="col-auto pt-2 d-none d-md-block">
                        <a targe="_blank" href="{{ route('print', [$package->slug]) }}" class="button button-pill button-small button-secondary button-border">
                            <i class="fas fa-print"></i> Print Page
                        </a>
                        {{-- <a href="#" class="button button-pill button-small button-secondary button-border">
                            <i class="far fa-images"></i> Photos
                        </a>
                        <a href="#" class="button button-pill button-small button-secondary button-border">
                            <i class="fas fa-video"></i> Videos
                        </a> --}}
                    </div>
                </div>
            </div>
            <section class="breadcrumb-wrap trip">
                <div class="container">
                    {!! new Breadcrumb($package) !!}
                </div>
            </section>
        </div>
    </section>

    <div class="trip-nav sticky-top" id="trip-nav">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light">

                <div class="trip_nav_text d-block d-lg-none">Overview</div>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#tripnav"
                    aria-controls="tripnav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="tripnav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link js-scroll-trigger" href="#overview">Overview</a>
                        </li>
                        @if($package->itineraries->count())
                        <li class="nav-item">
                            <a class="nav-link js-scroll-trigger" href="#itinerary">Itinerary</a>
                        </li>
                        @endif

                        @if($package->price_details)
                        <li class="nav-item">
                            <a class="nav-link js-scroll-trigger" href="#inclusion">Price Details</a>
                        </li>
                        @endif
                        @if($package->include)
                        <li class="nav-item">
                            <a class="nav-link js-scroll-trigger" href="#inclusion">Inclusion</a>
                        </li>
                        @endif

                        @if($package->exclude)
                        <li class="nav-item">
                            <a class="nav-link js-scroll-trigger" href="#exclusion">Exclusion</a>
                        </li>
                        @endif

                        @if($checklist)
                        <li class="nav-item">
                            <a class="nav-link js-scroll-trigger" href="#checklist">Check List</a>
                        </li>
                        @endif

                        @if($trip_details)
                        <li class="nav-item">
                            <a class="nav-link js-scroll-trigger" href="#trip_details">Important Info</a>
                        </li>
                        @endif

                        @if($review)
                        <li class="nav-item">
                            <a class="nav-link js-scroll-trigger" href="#review">Review</a>
                        </li>
                        @endif

                        @if($package->category_id <> 10 && $package->id <> 103)
                                <li class="nav-item"><a class="nav-link js-scroll-trigger" href="#fixed-departure">Fixed
                                        Departure</a></li>
                                @endif




                    </ul>

                    {{-- <div class="navbar-nav ml-auto border-0">
                        <button class="button button-pill button-primary button-inquiry button-small" data-toggle="modal" data-target="#inquiryModal">Make an Inquiry</button>
                    </div> --}}
                </div>

            </nav>
        </div>
    </div>

    <div class="container">

        <div class="row">
            <div class="col-lg-8 col-md-8">

                <section class="overview" id="overview">

                    <h2>Overview</h2>

                    <div class="trip-facts">
                        <ul class="row">
                            <li class="col-sm-6">
                                <i class="fas fa-clock fa-fw"></i>
                                <span class="title">Duration:</span>
                                <span class="value">{{ $package->days()  }}</span>
                            </li>
                            <li class="col-sm-6">
                                <i class="fas fa-level-up-alt fa-fw"></i>
                                <span class="title">Trip Grade:</span>
                                <span class="value">
                                    {{ config('grade.title.' . $package->grade) }}
                                    <a href="#" title="{{ config('grade.' . $package->grade) }}" data-toggle="popover"
                                        data-trigger="hover" data-content="{{ $package->grade_content }}"
                                        data-placement="top">
                                        <i class="fa fa-info-circle"></i>
                                    </a>
                                </span>
                            </li>
                            @foreach ($package->facts as $fact)
                            <li class="{{ $fact->col() }}">
                                <i class="{{ $fact->icon() }} fa-fw"></i>
                                <span class="title">{{ $fact->title }}:</span>
                                <span class="value">{{ $fact->value }}</span>
                            </li>
                            @endforeach
                        </ul>
                    </div>

                    @if ($package->highlight)
                    <div class="hightlight">
                        <h3>Highlights</h3>
                        {!! $package->highlight !!}
                    </div>
                    @endif

                    <div>
                        {!! $package->details !!}
                    </div>

                    @if($package->f_graphs && !$package->map)
                    <hr>
                    <canvas id="attitudeChart"></canvas>
                    @endif
                </section>

                @if($package->itineraries->count())

                <div class="trip-page-box itinerary" id="itinerary">
                    <h2>Trip Itinerary
                        <div class="itineraryshowhide">
                            <a href="javascript:void(0)" class="collapse-itinerary-all" style="display: none;">
                                <span class="fa fa-plus-square"></span> Collapse All</a>
                            <a href="javascript:void(0)" class="expand-itinerary-all" style="display: block;">
                                <span class="fa fa-minus-square"></span> Expand All</a>
                        </div>
                    </h2>
                    <div id="itineray_accordion" class="itineray_accordion">

                        @foreach ($package->itineraries as $key=>$itinerary)
                        <div class="card">
                            <div class="card-header">
                                <h4 class="mb-0 {{ $key == 0 ? null : 'collapsed' }}" data-toggle="collapse"
                                    data-target="#_{{ $itinerary->id }}" aria-expanded="true"
                                    aria-controls="collapseOne">
                                    {{$itinerary->day}}: {{$itinerary->outline}}
                                </h4>
                            </div>
                            @if($itinerary->details)
                            <div id="_{{ $itinerary->id }}" class="collapse {{ $key ==0 ? 'show': null }}"
                                data-parent="itineray_accordion">
                                <div class="card-body">
                                    {{-- @if($itinerary->hour || $itinerary->accommodation || $itinerary->meal)
                                    <div class="row icon">
                                        @if ($itinerary->hour)
                                        <div class="col col-sm-3">
                                            <i class="fa fa-fw fa-clock-o"></i> {{ $itinerary->hour }}</div>
                                        @endif @if ($itinerary->accommodation)
                                        <div class="col-8 col-sm-4">
                                            <i class="fa fa-fw fa-bed"></i> {{ $itinerary->accommodation }}</div>
                                        @endif @if ($itinerary->meal)
                                        <div class="col-12 col-sm-5">
                                            <i class="fa fa-fw fa-cutlery"></i> {{ $itinerary->meal }}</div>
                                        @endif
                                    </div>
                                    @endif --}}
                                    {!! $itinerary->details !!}
                                </div>
                            </div>
                            @endif
                        </div>
                        @endforeach

                    </div>

                    @if ($package->itinerary_note)
                    <div class="alert alert-info" role="alert">
                        {!! $package->itinerary_note !!}
                    </div>
                    @endif

                </div>
                @endif

                @if($package->price_details)
                <div class="trip-page-box price_details" id="price_details">
                    <h2>Price Details</h2>
                    {!! $package->price_details !!}
                </div>
                @endif

                @if($package->map && file_exists(public_path('uploads/maps/'.$package->map)))
                <div class="trip_map d-block d-lg-none">
                    <a href="#" data-toggle="modal" data-target="#mapModal">
                        <img src="{{ asset('uploads/maps/'.$package->map) }}" alt="{{ $package->title }} map"
                            title="{{ $package->title }} map" class="img-fluid">
                        <span><i class="fa fa-search-plus"></i> Click to enlarge</span>
                    </a>
                </div>
                @endif


                @if($package->include)
                <div class="trip-page-box inclusion" id="inclusion">
                    <h2>Inclusion</h2>
                    {!! $package->include !!}
                </div>
                @endif

                @if($package->exclude)
                <div class="trip-page-box exclusion" id="exclusion">
                    <h2>Exclusion</h2>
                    {!! $package->exclude !!}
                </div>
                @endif

                @if($checklist)
                <div class="trip-page-box checklist" id="checklist">
                    <h2>Check List</h2>
                    {!! $checklist->details !!}
                </div>
                @endif

                {{-- @if($package->trip_details)
                <div class="trip-page-box trip_details" id="trip_details">
                    {!! $package->trip_details !!}
                </div>
                @endif --}}

                @if($trip_details)
                <div class="trip-page-box trip_details" id="trip_details">
                    {!! $trip_details->details !!}
                </div>
                @endif

                @if($package->category_id <> 10 && $package->id <> 103)

                <div class="trip-page-box fixed-departure" id="fixed-departure">
                    <h2>Fixed Departure Dates</h2>
                    @if (count($package->dates) > 0)
                    <div class="table-responsive table-fixed-header table-fixed-departure">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Price</th>
                                    <th>Status</th>
                                    <th class="ftw-70">Book</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($package->dates as $date)
                                <tr {{ $date->is_fullmoon?'class=fullmoon':null }}>
                                    <td>
                                        {{ $date->start() }}
                                        @if($date->is_fullmoon)
                                        <span class="badge badge-info">fullmoon</span>
                                        @endif
                                    </td>
                                    <td>{{ $date->end() }}</td>
                                    <td>USD {{ $date->usd_price }}</td>
                                    <td>{{ $date->status() }}

                                    </td>
                                    <td>
                                        <a href="{{ url('booking/' . $package->slug . '?_s='.$date->start .'&_e=' . $date->end) }}">Join</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <p>We will easily organize this trip on the dates requested by you. Please <a
                            href="{{ url('contact-us') }}">contact us</a> for your customized
                        departure date</p>
                    @endif
                </div>
                @endif

                @if($review)
                <div class="trip-page-box inner-review" id="review">
                    <h2>Review</h2>

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
                            <p class="rating">
                                @for ($i = 0; $i < $review->rating; $i++)
                                    <i class="fa fa-star active"></i>
                                    @endfor
                                    @for ($k = ($i-1); $k < 4; $k++) <i class="fa fa-star deactive"></i>
                                        @endfor
                            </p>
                            {!! $review->details !!}
                            <p class="name">By <i><span>{{ $review->name }} </span>,
                                    <b>{{ $review->country->name }}</b></i></p>

                            <hr>

                            <a class="button button-primary button-small button-pill"
                                href="{{ url('reviews') }}">View more reviews</a>
                        </div>
                    </div>

                </div>
                @endif


            </div>
            <div class="col-lg-4 col-md-4">

                <div class="ml-md-3 sticky-top" style="top: 100px;z-index:0">

                    <div class="price-box d-none d-lg-block">

                        @if ($package->price)
                            <span class="p_title">Trip cost</span>
                            <span class="price">
                                <small>USD</small>
                                {{ $package->price }}
                            </span>
                        @else
                            <span class="p_title">Price On Request</span>
                        @endif

                        <div class="clearfix"></div>

                        <div class="price_booking">
                            @if ($package->price)
                            <a href="{{ route('booking', $package->slug) }}" class="button button-primary button-small button-rounded">Book Now</a>
                            @endif
                            <a href="{{ url('contact-us') }}" class="button button-secondary button-small button-rounded button-border">Inquiry</a>
                        </div>

                    </div>

                    <div class="ask-export">
                        <div class="title">
                            <h3>ASK AN EXPERT</h3>
                        </div>
                        <ul >
                            <li class="phone">
                                <i class="fa fa-phone fa-fw"></i> <span>+977 984-181-6439 (Ajaya)</span><br>
                                24/7 customer support
                            </li>
                            <li class="email">
                                <i class="fa fa-envelope fa-fw"></i>
                                <a href="mailto:info@himalayathundertreks.com">info@himalayathundertreks.com</a><br>
                                <a href="mailto:dahalajaya7@gmail.com">dahalajaya7@gmail.com</a>
                            </li>
                        </ul>
                    </div>

                    @if($package->map && file_exists(public_path('uploads/maps/'.$package->map)))
                    <div class="trip_map d-none d-lg-block">
                        <a href="#" data-toggle="modal" data-target="#mapModal">
                            <img src="{{ asset('uploads/maps/'.$package->map) }}" alt="{{ $package->title }} map"
                                title="{{ $package->title }} map" class="img-fluid">
                            <span><i class="fa fa-search-plus"></i> Click to enlarge</span>
                        </a>
                    </div>
                    @endif


                    @if($infos && count($infos) > 0)
                    <div class="content-right menu">

                        <div class="right-list-menu">
                            <h3>Trip Info</h3>
                            <ul>
                                @foreach ($infos as $info)
                                <li>
                                    <a href="{{ $info->url }}">{{ $info->title }}</a>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    @endif

                </div>
            </div>
        </div>

        <div class="trip-f00ter-nav">

            <a href="{{ route('print', [$package->slug, '_ref']) }}"
                class="button button-primary button-uppercase button-pill button-small button-border "><span
                    class="fa fa-fw fa-file-pdf-o"></span>Printable Version</a>

{{--            <a href="#" class="button button-primary button-uppercase button-pill button-small button-border"--}}
{{--                data-toggle="modal" data-target="#customizeModal"><span class="fa fa-fw fa-sliders"></span> Customize this--}}
{{--                trip</a>--}}

            <a href="{{ route('booking', $package->slug) }}"
                class="button button-primary button-uppercase button-pill button-small button-border "><span
                    class="fa fa-fw fa-ticket"></span> Book This Trip</a>
        </div>
    </div>
</section>
@endsection

@section('script')

@if($package->slides->count() > 0)
<div class="modal fade trip-gallery-modal" id="tripGalleryModal" tabindex="-1" role="dialog" aria-label="{{ $package->title }} photos"
    aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
            <div id="tripGalleryCarousel" class="carousel slide" data-interval="false">
                <div class="carousel-inner">
                    @foreach ($package->slides as $key => $slide)
                    <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                        <picture>
                            @if($webp = $slide->webp('1600x600'))
                            <source type="image/webp" srcset="{{ $webp }}">
                            @endif
                            <img src="{{ $slide->image_path }}" alt="{{ $slide->title }}" loading="lazy" class="d-block w-100">
                        </picture>
                        @if($slide->title)
                        <p class="trip-gallery-modal__caption">{{ $slide->title }}</p>
                        @endif
                    </div>
                    @endforeach
                </div>
                @if($package->slides->count() > 1)
                <a class="carousel-control-prev" href="#tripGalleryCarousel" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#tripGalleryCarousel" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
                @endif
            </div>
        </div>
    </div>
</div>
<script>
    $(function () {
        $('[data-gallery-index]').on('click', function (e) {
            e.preventDefault();
            $('#tripGalleryCarousel').carousel(parseInt($(this).data('gallery-index'), 10));
            $('#tripGalleryModal').modal('show');
        });
        $(document).on('keydown', function (e) {
            if (!$('#tripGalleryModal').hasClass('show')) return;
            if (e.key === 'ArrowLeft') $('#tripGalleryCarousel').carousel('prev');
            if (e.key === 'ArrowRight') $('#tripGalleryCarousel').carousel('next');
        });
    });
</script>
@endif
@if($package->map && file_exists(public_path('uploads/maps/'.$package->map)))
<div class="modal fade customModal mapModal" id="mapModal" tabindex="-1" role="dialog" aria-labelledby="mapModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content text-center">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span class="lnr lnr-cross"></span>
                </button>
                <h3>{{ $package->title }} Map</h3>
                <p>
                    <img src="{{ asset('uploads/maps/'.$package->map) }}" alt="{{ $package->title }} map"
                        title="{{ $package->title }} map" class="img-fluid">
                </p>
            </div>
        </div>
    </div>
</div>
@endif

{{--<div class="modal fade tinyModal" id="customizeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"--}}
{{--    aria-hidden="true">--}}
{{--    <div class="modal-dialog" role="document">--}}
{{--        <div class="modal-content">--}}
{{--            @if($errors->any())--}}
{{--            <div class="alert alert-danger">--}}
{{--                <ul class="mb-0">--}}
{{--                    @foreach($errors->all() as $error)--}}
{{--                    <li>{{ $error }}</li>--}}
{{--                    @endforeach--}}
{{--                </ul>--}}
{{--            </div>--}}
{{--            @endif--}}

{{--            <form action="{{ route('customize') }}" method="post" class="needs-validation" novalidate>--}}
{{--                {{ csrf_field() }}--}}
{{--                <div class="modal-header">--}}
{{--                    <h5 class="modal-title" id="exampleModalLabel">Customize Your Trip</h5>--}}
{{--                </div>--}}
{{--                <div class="modal-body">--}}
{{--                    <div class="form-group">--}}
{{--                        <input type="hidden" class="form-control" id="package" name="package"--}}
{{--                            value="{{ isset($package) ? $package->title : null  }}">--}}
{{--                        <input type="text" class="form-control" id="full_name" name="full_name"--}}
{{--                            aria-describedby="emailHelp" placeholder="Full Name" required>--}}
{{--                    </div>--}}
{{--                    <div class="form-group">--}}
{{--                        <input type="email" class="form-control" id="email" name="email" placeholder="Email Address"--}}
{{--                            required="">--}}
{{--                    </div>--}}
{{--                    <div class="form-group">--}}
{{--                        <input type="number" min="1" class="form-control" id="phone" name="phone" placeholder="Phone">--}}
{{--                    </div>--}}
{{--                    <div class="form-group">--}}
{{--                        <select class="form-control" name="country" id="country" required="">--}}
{{--                            <option value="">-- Select Country --</option>--}}
{{--                            @foreach (App\Country::all() as $country)--}}
{{--                            <option value="{{ $country->name }}">{{ $country->name }}</option>--}}
{{--                            @endforeach--}}
{{--                        </select>--}}
{{--                    </div>--}}
{{--                    <div class="form-group">--}}
{{--                        <input type="number" class="form-control" id="duration" name="duration" required--}}
{{--                            placeholder="Duration">--}}
{{--                    </div>--}}
{{--                    <div class="form-group">--}}
{{--                        <input type="text" class="form-control" id="hotel_category" name="hotel_category" required--}}
{{--                            placeholder="Hotel Category">--}}
{{--                    </div>--}}
{{--                    <div class="form-group">--}}
{{--                        <input type="text" class="form-control" id="flight_destination" name="flight_destination"--}}
{{--                            required placeholder="Flight Destination">--}}
{{--                    </div>--}}
{{--                    <div class="form-group">--}}
{{--                        <input type="number" min="1" class="form-control" id="number_of_traveller"--}}
{{--                            name="number_of_traveller" placeholder="Number of Traveller">--}}
{{--                    </div>--}}
{{--                    <div class="form-group">--}}
{{--                        <textarea name="message" class="form-control" placeholder="Message" required=""></textarea>--}}
{{--                    </div>--}}

{{--                    <div class="row form-group">--}}
{{--                        <div class="col-md-4">--}}
{{--                            <img src="{{ route('captchaimage') }}" alt="Captcha">--}}
{{--                        </div>--}}

{{--                        <div class="col-md-8">--}}
{{--                            <input type="text" class="form-control {{ $errors->has('captcha') ? ' is-invalid' : '' }}"--}}
{{--                                id="captcha" name="captcha" placeholder="Enter Captcha">--}}
{{--                            @if ($errors->has('captcha'))--}}
{{--                            <span class="help-block text-danger"><strong>{{ $errors->first('captcha') }}</strong></span>--}}
{{--                            @endif--}}
{{--                        </div>--}}
{{--                    </div>--}}

{{--                    <div class="row">--}}
{{--                        <div class="col-sm-5 offset-sm-1">--}}
{{--                            <button type="submit"--}}
{{--                                class="button button-primary button-raised button-rounded button-block">Send</button>--}}
{{--                        </div>--}}
{{--                        <div class="col-sm-5">--}}
{{--                            <button type="button"--}}
{{--                                class="button button-secondary button-raised button-rounded button-block"--}}
{{--                                data-dismiss="modal">Close</button>--}}
{{--                        </div>--}}
{{--                    </div>--}}

{{--                </div>--}}
{{--            </form>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}
@endsection