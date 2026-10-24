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
        <div class="row">
            <div class="col-sm-{{ (isset($parent) && $parent)?8:12 }}">
                <section class="overview">
                    <h1>
                        {{ $page->title }}
                    </h1>
                    @foreach($teams as $team)
                        @include('team')
                    @endforeach
                </section>


            </div>
            @if (isset($parent) && $parent)
            <div class="col-sm-4">
                <div class="content-right">
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

                {{-- @if($page->id == 2)

                    <div class="content-right mt-4">
                        <div class="right-menu">
                            <h3>COMPANY DOCUMENTS</h3>
                            <div id="lightgallery">
                                @foreach ($docs as $doc)
                                <a href="{{ asset('uploads/legaldocs/' . $doc->image) }}" title="{{ $doc->title }}" class="pt-4">
                                    <img src="{{ asset('uploads/legaldocs/' . $doc->image) }}" alt="{{ $doc->title }}" class="img-fluid">
                                </a>
                                @endforeach
                            </div>
                        </div>
                    </div>

                @endif --}}


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