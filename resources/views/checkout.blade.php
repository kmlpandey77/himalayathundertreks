@extends('layouts.app', ['inquiry_page' => $package->title])
@section('title') {{ $package->m_title }}
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

<section class="breadcrubwapper">
    <div class="container">
        {!! new Breadcrumb($package) !!}
    </div>
</section>

<div class="trip-nav fixed-top" id="trip-nav">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light">

            <div class="trip_nav_text d-block d-lg-none">Overview</div>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#tripnav" aria-controls="tripnav" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="tripnav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link js-scroll-trigger" href="#overview">Overview</a>
                    </li>
                    @if($package->itineraries()->count())
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

                    @if($package->trip_details)
                    <li class="nav-item">
                        <a class="nav-link js-scroll-trigger" href="#trip_details">Trip Details</a>
                    </li>
                    @endif

                    @if($package->category_id <> 10 && $package->id <> 103)
                    <li class="nav-item">
                        <a class="nav-link js-scroll-trigger" href="#fixed-departure">Fixed Departure</a>
                    </li>
                    @endif

                    @if($review)
                    <li class="nav-item">
                        <a class="nav-link js-scroll-trigger" href="#review">Review</a>
                    </li>
                    @endif

                </ul>

                {{-- <div class="navbar-nav ml-auto border-0">
                    <button class="button button-pill button-primary button-inquiry button-small" data-toggle="modal" data-target="#inquiryModal">Make an Inquiry</button>
                </div> --}}
            </div>

        </nav>
    </div>
</div>


<section class="content gray-bg trip">
    <div class="container" itemscope itemtype="http://schema.org/Product">


    <div class="row">
            <div class="col-lg-8">

                {{-- <div class="card bg-light border-light">
                    <div class="card-body py-3">
                        <div class="addthis_inline_share_toolbox"></div>
                    </div>
                </div> --}}

                <section class="overview" id="overview">
                    <h1 itemprop="name">{{ $package->title }}</h1>

                    <ul class="feature">
                        <li>Best Price Guaranteed</li>
                        <li>Fully Protected</li>
                        <li>Expert Knowledge</li>
                        <li>Socially Responsible</li>
                    </ul>

                    <section class="innerslide" style="min-height: 100px">
                        <div class="owl-carousel" id="innerslide">
                            @foreach ($package->slides as $key => $slide)
                            <div class="item">
                                <img src="{{ asset('uploads/slide/' . $slide->image) }}" alt="{{ $slide->title }}" title="{{ $slide->title }}">
                                <p>{{ $slide->title }}</p>
                            </div>
                            @endforeach
                        </div>
                    </section>

                    @if ($package->highlight)
                    <div class="hightlight">
                        {!! $package->highlight !!}
                    </div>
                    @endif

                    <div itemprop="description">
                        {!! $package->details !!}
                    </div>

                    @if($package->f_graphs && !$package->map)
                    <hr>
                    <canvas id="attitudeChart"></canvas>
                    @endif
                </section>

                @if($package->itineraries()->count())

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
                                <h4 class="mb-0 {{ $key == 0 ? null : 'collapsed' }}" data-toggle="collapse" data-target="#_{{ $itinerary->id }}" aria-expanded="true"
                                    aria-controls="collapseOne">
                                    {{$itinerary->day}}: {{$itinerary->outline}}
                                </h4>
                            </div>
                            @if($itinerary->details)
                            <div id="_{{ $itinerary->id }}" class="collapse {{ $key ==0 ? 'show': null }}" data-parent="itineray_accordion">
                                <div class="card-body">
                                    @if($itinerary->hour || $itinerary->accommodation || $itinerary->meal)
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
                                    @endif
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
                        <img src="{{ asset('uploads/maps/'.$package->map) }}" alt="{{ $package->title }} map" title="{{ $package->title }} map" class="img-fluid">
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

                @if($package->trip_details)
                <div class="trip-page-box trip_details" id="trip_details">
                    {!! $package->trip_details !!}
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
                                    <th>USD Price</th>
                                    <th>INR Price</th>
                                    <th>Status</th>
                                    <th class="ftw-70">Book</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($departure_dates as $month=>$dates)
                                    <tr class="month">
                                        <td colspan="6">{{ $month }}</td>
                                    </tr>
                                    @foreach ($dates as $date)
                                    <tr {{ $date->is_fullmoon?'class=fullmoon':null }}>
                                        <td>
                                            {{ $date->start() }}
                                            @if($date->is_fullmoon)
                                                <span class="badge badge-info">fullmoon</span>
                                            @endif
                                        </td>
                                        <td>{{ $date->end() }}</td>
                                        <td>USD {{ $date->usd_price }}</td>
                                        <td>INR {{ $date->inr_price }}</td>
                                        <td>{{ $date->status() }}

                                        </td>
                                        <td>
                                            <a href="{{ url('booking/' . $package->slug) }}">Book</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <p>We will easily organize this trip on the dates requested by you. Please <a href="{{ url('contact-us') }}">contact us</a> for your customized
                        departure date</p>
                    @endif
                </div>
                @endif

                @if($review)
                <div class="trip-page-box inner-review" id="review" itemprop="review" itemscope itemtype="http://schema.org/Review">
                    <span itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating">
                        <meta itemprop="ratingValue" content = "100%">
                    </span>
                    <h2>Review</h2>
                    <div class="media">
                            @if ($review->image)
                            <img class="align-self-start mr-4 d-none d-lg-block" src="{{ $review->thumb() }}" alt="{{ $review->name }}"  width="200">
                            @else
                            <img class="align-self-start mr-4 d-none d-lg-block" src="{{ asset('images/default/user.jpg') }}" alt="{{ $review->name }}"  width="200">
                            @endif

                        <div class="media-body">
                        <h5 class="mt-0">{{ $review->title }}</h5>
                        <p class="rating" itemprop="description">
                            @for ($i = 0; $i < $review->rating; $i++)
                                <i class="fa fa-star active"></i>
                                @endfor
                                @for ($k = ($i-1); $k < 4; $k++)
                                <i class="fa fa-star deactive"></i>
                            @endfor
                        </p>
                        {!! $review->details !!}
                        <p class="name">By <i><span itemprop="author">{{ $review->name }} </span>, <b>{{ $review->country->name }}</b></i></p>

                        <hr>

                        {{-- @if($review->link)
                        <a target="_blank" href="{{ $review->link }}" class="button button-primary button-small button-pill">View this review in TripAdvisor</a>
                        @endif --}}

                        <a class="button button-primary button-small button-pill" href="{{ url('reviews') }}">View more reviews</a>

                        </div>
                    </div>
                </div>
                @endif

            </div>
            <div class="col-lg-4">

                <div class="price-box d-none d-lg-block">
                    {{-- <h4>Trip Price</h4> --}}
                    <div class="row no-gutters">
                        @if ($package->price)
                        <div class="col-sm">
                            <div class="price usd">
                                <span class="p_title">USD Price</span>
                                <span>{{ $package->usd_price }}</span>
                                <small>per person</small>
                            </div>
                        </div>
                        <div class="col-sm">
                            <div class="price inr">
                                <span class="p_title">INR Price</span>
                                <span>{{ $package->inr_price }}</span>
                                <small>per person</small>
                            </div>
                        </div>
                        @else
                        <div class="col-sm">
                            <div class="price usd">
                                <span class="p_title">Price On Request</span>
                            </div>
                        </div>
                        @endif
                    </div>


                    <div class="clearfix"></div>

                    {{-- <button class="button button-secondary button-pill" data-toggle="modal" data-target="#inquiryModal">Make an Inquiry</button> --}}
                    @if ($package->price)
                    <a href="{{ route('booking', $package->slug) }}" target="_blank" class="button button-secondary button-pill">Book This Trips</a>
                    @else
                    <a href="{{ url('contact-us') }}" target="_blank" class="button button-secondary button-pill">Contact us</a>
                    @endif

                </div>

                @if($package->days() || $package->facts()->count())
                <div class="trip-facts d-none d-lg-block">
                    <h3>Trip Overview</h3>
                    <ul>
                        <li class="media">
                            <div class="icon mr-3">
                                <i class="fa fa-clock-o fa-fw"></i>
                            </div>
                            <div class="media-body">
                                <span class="title">Duration:</span>
                                <span class="value">{{ $package->days() }}</span>
                            </div>
                        </li>


                        @if ($package->grade)
                        <li class="media">
                            <div class="icon mr-3">
                                <i class="fa fa-signal fa-fw"></i>
                            </div>
                            <div class="media-body">
                                <span class="title">Trip Grade:</span>
                                <span class="value">
                                    {{ config('grade.title.' . $package->grade) }}
                                    <a href="#" data-toggle="popover" data-trigger="hover" data-content="{{ $package->grade_content }}"
                                        data-placement="top">
                                        <i class="fa fa-info-circle"></i>
                                    </a>
                                </span>
                            </div>
                        </li>
                        @endif
                        @foreach ($package->facts as $fact)
                        <li class="media">
                            <div class="icon mr-3">
                                <i class="fa fa-{{ $fact->icon() }} fa-fw"></i>
                            </div>
                            <div class="media-body">
                                <span class="title">{{ $fact->title }}:</span>
                                <span class="value">{{ $fact->value }}</span>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
                @endif

                @if($package->map && file_exists(public_path('uploads/maps/'.$package->map)))
                <div class="trip_map d-none d-lg-block">
                    <a href="#" data-toggle="modal" data-target="#mapModal">
                        <img src="{{ asset('uploads/maps/'.$package->map) }}" alt="{{ $package->title }} map" title="{{ $package->title }} map" class="img-fluid">
                        <span><i class="fa fa-search-plus"></i> Click to enlarge</span>
                    </a>
                </div>
                @endif


                @if($infos)
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

                <div class="content-right related_trip">
                    <div class="right-menu">
                        <h3>Related Trip</h3>
                        @foreach ($related_trip as $trip)
                        <div class="item">
                            <a href="{{ $trip->url }}" class="row">
                                <span class="col-3"><img src="{{$trip->image('400x300')}}" alt="{{ $package->title }}" class="img-fluid"></span>
                                <span class="col-9">
                                    <h5>{{ $trip->title }}</h5>
                                    <p>{{ $trip->days() }}</p>
                                </span>
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>

        <div class="trip-f00ter-nav">

            <a target="_blank" href="{{ route('pdf', [$package->slug, '_ref']) }}" class="button button-primary button-uppercase button-pill button-small button-border "><span class="fa fa-fw fa-file-pdf-o"></span> Download PDF</a>

            <a href="#" class="button button-primary button-uppercase button-pill button-small button-border" data-toggle="modal" data-target="#customizeModal"><span class="fa fa-fw fa-sliders"></span> Customize this trip</a>

            <a href="{{ route('booking', $package->slug) }}" class="button button-primary button-uppercase button-pill button-small button-border "><span class="fa fa-fw fa-ticket"></span> Book This Trip</a>

            {{-- <a href="#" class="button button-primary button-uppercase button-pill button-small button-border" data-toggle="modal" data-target="#tellafriendModal"><span class="fa fa-fw fa-share-alt"></span> Tell a friend</a> --}}

        </div>
    </div>
</section>
@endsection

@section('script')

<div class="modal fade customModal mapModal" id="mapModal" tabindex="-1" role="dialog" aria-labelledby="mapModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content text-center">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span class="lnr lnr-cross"></span>
            </button>
                <h3>{{ $package->title }} Map</h3>
                <p>
                    <img src="{{ asset('uploads/maps/'.$package->map) }}" alt="{{ $package->title }} map" title="{{ $package->title }} map" class="img-fluid">
                </p>
            </div>
        </div>
    </div>
</div>

<div class="modal fade tinyModal" id="customizeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('customize') }}" method="post" class="needs-validation" novalidate>
                {{ csrf_field() }}
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Customize Your Trip</h5>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <input type="hidden" class="form-control" id="package" name="package" value="{{ isset($package) ? $package->title : null  }}">
                        <input type="text" class="form-control" id="full_name" name="full_name" aria-describedby="emailHelp" placeholder="Full Name"
                            required>
                    </div>
                    <div class="form-group">
                        <input type="email" class="form-control" id="email" name="email" placeholder="Email Address" required="">
                    </div>
                    <div class="form-group">
                        <input type="number" min="1" class="form-control" id="phone" name="phone" placeholder="Phone">
                    </div>
                    <div class="form-group">
                        <select class="form-control" name="country" id="country" required="">
                          <option value="">-- Select Country --</option>
                          @foreach (App\Country::all() as $country)
                            <option value="{{ $country->name }}">{{ $country->name }}</option>
                          @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="number" class="form-control" id="duration" name="duration" required placeholder="Duration">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="hotel_category" name="hotel_category" required placeholder="Hotel Category">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="flight_destination" name="flight_destination" required placeholder="Flight Destination">
                    </div>
                    <div class="form-group">
                        <input type="number" min="1" class="form-control" id="number_of_traveller" name="number_of_traveller" placeholder="Number of Traveller">
                    </div>
                    <div class="form-group">
                        <textarea name="message" class="form-control" placeholder="Message" required=""></textarea>
                    </div>

                    <div class="row">
                        <div class="col-sm-5 offset-sm-1">
                            <button type="submit" class="button button-primary button-raised button-rounded button-block">Send</button>
                        </div>
                        <div class="col-sm-5">
                            <button type="button" class="button button-secondary button-raised button-rounded button-block" data-dismiss="modal">Close</button>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>


<script>
    $(document).ready(function () {
        // $('#tellafriendModal').modal('show');
        $("#innerslide").owlCarousel({
            loop: true,
            nav:true,
            navText: [
                '<i class="fa fa-angle-left"></i>',
                '<i class="fa fa-angle-right"></i>'
            ],
            items: 1,
            dots: false,
            autoplay: true,
        });

        var tl = $(".trip-left").outerHeight();
        var tr = $(".trip-right").outerHeight();
        if(tl>tr){
            $(".trip-right").css('min-height', tl);
        }


    });

</script>
@endsection