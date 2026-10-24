@extends('layouts.app')

@section('title')
{{ $page->m_title }}
@endsection

@section('meta')
<meta content="{{ $page->m_description }}" name="description"/>
<meta content="{{ $page->m_keyword }}" name="keywords"/>
<meta content="{{ $page->m_description }}" property="og:description"/>
@endsection

@section('content')
<section class="breadcrubwapper">
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

            @if($videos->count())
            <div class="row">
                @foreach($videos as $video)
                <div class="col-sm-6 mb-5">
                    <iframe width="100%" height="300" src="https://www.youtube.com/embed/{{ $video->video_id }}" frameborder="0" allowfullscreen></iframe>
                    <h4>{{ $video->title }}</h4>
                </div>
                @endforeach
            </div>
            @endif

        </section>
    </div>
</section>
@endsection
