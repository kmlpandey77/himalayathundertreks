@extends('layouts.app')

@section('title')
{{ $page->m_title }}@endsection

@section('meta')
<meta content="{{ $page->m_description }}" name="description"/>
<meta content="{{ $page->m_keyword }}" name="keywords"/>
@endsection

@section('content')
<section class="breadcrubwapper">
    <div class="container">
        {!! new Breadcrumb($page) !!}
    </div>
</section>
<section class="travel-blog content gray-bg {{ $page->slug }}">
    <div class="container">
        <section class="overview">
            <h1 class="blog-heading">
                {{ $page->title }}
            </h1>
            @if ($blogs->count())
            <div class="row">
                @foreach ($blogs as $key=>$blog)
                    @include('blog.card')
                @endforeach
            </div>
            @if ($blogs->hasPages())
            <nav class="blog-pagination" aria-label="Blog pages">
                {{ $blogs->links('vendor.pagination.bootstrap-4') }}
            </nav>
            @endif
            @else
            <p class="blog-empty">
                No blog posts yet. Check back soon.
            </p>
            @endif
        </section>
    </div>
</section>
@endsection
