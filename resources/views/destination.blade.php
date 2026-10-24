@extends('layouts.app')

@section('title')
{{ $destination->m_title }}
@endsection

@section('meta')
<meta content="{{ $destination->m_description }}" name="description"/>
<meta content="{{ $destination->m_keyword }}" name="keywords"/>
<meta content="{{ $destination->m_description }}" property="og:description"/>
@endsection

@section('content')

<section class="breadcrumb-wrap">
    <div class="container">
        {!! new Breadcrumb($destination) !!}
    </div>
</section>

<section class="content {{ $destination->slug }}">

    <div class="container">
        <div class="row">
            <div class="col-sm-7">
                <section class="overview">
                    <h1>
                        {{ $destination->title }}
                    </h1>
                    {!! $destination->details !!}
                </section>
            </div>
            <div class="col-sm-5">
                <div class="content-right ml-3 mt-3">

                    <div class="related-box">
                        <h3>Activities in {{ $destination->title }} </h3>

                        <ul>
                            @foreach ($destination->activities as $category)
                            <li>
                                <a href="{{ $category->url }}" class="row">
                                    <div class="col-4 img"><img src="{{ $category->image_path }}" class="img-fluid"></div>
                                    <div class="col-8 text">
                                        <h4>{{ $category->title }}</h4>
                                        <p>{{ Str::limit(strip_tags($category->details),80) }}</p>
                                    </div>
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </div>


                </div>

            </div>
        </div>
    </div>
</section>
@endsection
