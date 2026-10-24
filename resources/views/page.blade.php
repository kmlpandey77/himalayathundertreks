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
<section class="breadcrumb-wrap">
    <div class="container">
        {!! new Breadcrumb($page) !!}
    </div>
</section>
<section class="content {{ $page->slug }}">
    <div class="container">
        <div class="row">
            <div class="col-sm-{{ (isset($parent) && $parent)?8:12 }}">
                <section class="overview">
                    <h1>
                        {{ $page->title }}
                    </h1>
                    {!! $page->details !!}
                </section>


            </div>
            @if (isset($parent) && $parent)
            <div class="col-sm-4">
                <div class="content-right ml-3">
                    <div class="right-menu">
                        <h3>
                            {{ $parent->title }}
                        </h3>
                        <ul>
                            @foreach ($sidebar as $menu)
                            <li>
                                <a href="{{ url($menu->slug) }}">
                                    {{ $menu->title }}
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

            </div>
            @endif
        </div>
    </div>
</section>
@endsection

@section('script')
<link rel="stylesheet" href="{{ asset('vendors/lightgallery/lightgallery.min.css') }}">
<script src="{{ asset('vendors/lightgallery/lightgallery.min.js') }}"></script>
<script src="{{ asset('vendors/lightgallery/lg-zoom.js') }}"></script>
<script>
    $(document).ready(function() {
        lightGallery(document.getElementById('lightgallery'),{
            download:false,
            zoom: true,
        });
    });
</script>
@endsection