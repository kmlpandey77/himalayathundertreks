@extends('layouts.app')
@section('title') {{ $activity->m_title }}
@endsection

@section('meta')
<meta name="description" content="{{ $activity->m_description }}">
<meta name="keywords" content="{{ $activity->meta_keyword }}">
<meta property="og:description"   content="{{ $activity->m_description }}" />
@endsection

@section('content')

<section class="breadcrumb-wrap">
    <div class="container">
        {!! new Breadcrumb($activity) !!}
    </div>
</section>

<section class="content category {{ $activity->slug }}">

    <div class="container">
        <div class="row">
        <div class="{{$activity->regions->count() ? 'col-sm-7' : 'col-sm-12' }}">
                <section class="overview">
                    <h1>
                        {{ $activity->title }}
                    </h1>
                    {!! $activity->details !!}
                </section>
            </div>
            @if($activity->regions->count())
            <div class="col-sm-5">
                <div class="content-right ml-3 mt-3">

                    <div class="related-box">
                        <h3>Regions </h3>

                        <ul>
                            @foreach ($activity->regions as $region)
                            <li>
                                <a href="{{ $region->url }}" class="row">
                                    <div class="col-4 img"><img src="{{ $region->image_path }}" class="img-fluid"></div>
                                    <div class="col-8 text">
                                        <h4>{{ $region->title }}</h4>
                                        <p>{{ Str::limit(strip_tags($region->details),80) }}</p>
                                    </div>
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            @endif
        </div>

        @if (count($activity->packages))
        <div class="card-list">
            <div class="inner-heading"><h3>Package</h3></div>
            <div class="row">
                @foreach ($activity->packages as $package)
                @include('package-card')
                @endforeach
            </div>
        </div>
        @endif
    </div>
</section>
@endsection

@section('script')
<script>
    $(function(){
        $(document).on('click', 'a.overview-view-more',
            function(e){
                e.preventDefault();
                $('#mini-overview').find('.txt').toggleClass('expand', 1000);
                $(this).text(function(i, text){
                    return text === "View More" ? "View Less" : "View More";
                })
            }
        );

    })
</script>
@endsection