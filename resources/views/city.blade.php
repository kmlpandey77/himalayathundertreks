@extends('layouts.app')

@section('title', $city->name)

@section('meta')
<meta content="{{ $city->name }}" name="description"/>
<meta content="{{ $city->name }}" name="keywords"/>
<meta content="{{ $city->name }}" property="og:description"/>
@endsection

@section('content')
<section class="breadcrubwapper">
    <div class="container">
        {!! new Breadcrumb($city) !!}
    </div>
</section>
<section class="content gray-bg {{ $city->slug }}">
    <div class="container">
        <section class="overview">
            <h1>
                {{ $city->name }}
            </h1>
            <hr>

            <div class="row">
                @if($city->hotels()->count())
                    @foreach($city->hotels as $hotel)
                    <div class="col-sm-6 mt-5">
                        <div class="row">
                            <div class="col-5">
                                <img src="{{ asset('uploads/hotel/'. $hotel->image) }}" alt="{{ $hotel->name }}" class="img-fluid">
                            </div>
                            <div class="col-7">
                                <h4>{{ $hotel->name }}</h4>
                                <div class="rating">
                                    @for($i=0;$i < (int)$hotel->rating; $i++)
                                    <i class="fa fa-star active" style="color: #FF6D00"></i>
                                    @endfor

                                    @for($k=$i; $k < 5; $k++)
                                    <i class="fa fa-star" style="color: #ddd;"></i>
                                    @endfor
                                </div>

                                <p>Price Range: {{ $hotel->price }}</p>

                            </div>
                        </div>

                    </div>
                    @endforeach
                @endif
            </div>


        </section>
    </div>
</section>
@endsection
