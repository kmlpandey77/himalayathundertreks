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

            @if($albums->count())
            <div class="row">
                @foreach($albums as $album)
                <div class="col-sm-4">
                    <div class="card">
                      <img src="{{ $album->thumb }}" class="card-img-top" alt="{{ $album->title }}">
                      <div class="card-body">
                        <h5 class="card-title">{{ $album->title }}</h5>
                      </div>
                      <div class="card-footer text-muted">
                       <a href="{{ route('photo-gallery', $album->id) }}" class="button button-primary button-small button-pill">View Photos</a>
                      </div>
                    </div>
                </div>
                @endforeach
            </div>
            @endif

        </section>
    </div>
</section>
@endsection
