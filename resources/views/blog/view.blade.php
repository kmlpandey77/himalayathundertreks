@extends('layouts.app')

@php
    $published = $blog->event_date ?? $blog->created_at;
    $heroPath = $blog->image ? public_path('uploads/blogs/' . $blog->image) : null;
    $heroSize = $heroPath && file_exists($heroPath) ? @getimagesize($heroPath) : null;
@endphp

@section('title')
{{ $blog->m_title }}
@endsection

@section('meta')
<meta content="{{ $blog->m_description }}" name="description"/>
<meta content="{{ $blog->m_keyword }}" name="keywords"/>
<meta property="og:title" content="{{ $blog->title }}" />
<meta property="og:description" content="{{ Str::limit(Str::squish(html_entity_decode(strip_tags($blog->details), ENT_QUOTES | ENT_HTML5)), 160) }}" />
@if($heroSize)
<meta property="og:image" content="{{ asset('uploads/blogs/' . $blog->image) }}" />
@endif
<meta property="article:published_time" content="{{ $published->toDateString() }}" />
@endsection

@section('og_type', 'article')

@section('schema')
@php
    $articleSchema = [
        '@context' => 'https://schema.org',
        '@type' => 'BlogPosting',
        '@id' => $blog->url . '#article',
        'mainEntityOfPage' => $blog->url,
        'headline' => \Illuminate\Support\Str::limit($blog->title, 110, ''),
        'description' => $blog->m_description,
        'datePublished' => $published->toIso8601String(),
        'dateModified' => ($blog->updated_at ?? $published)->toIso8601String(),
        'inLanguage' => 'en',
        'author' => ['@id' => url('/') . '#organization'],
        'publisher' => ['@id' => url('/') . '#organization'],
        'wordCount' => str_word_count(strip_tags((string) $blog->details)),
    ];
    if ($heroSize) {
        $articleSchema['image'] = [
            '@type' => 'ImageObject',
            'url' => asset('uploads/blogs/' . $blog->image),
            'width' => $heroSize[0],
            'height' => $heroSize[1],
        ];
    }
@endphp
<script type="application/ld+json">{!! json_encode($articleSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) !!}</script>
@endsection

@section('content')
<section class="breadcrubwapper">
    <div class="container">
        {!! new Breadcrumb($blog, 'blog') !!}
    </div>
</section>
<section class="content gray-bg">
    <div class="container">
        <div class="row">
            <div class="{{ $other_blogs->count() ? 'col-lg-8' : 'col-lg-10 offset-lg-1' }}">
                <article class="blog-article overview">
                    <header class="blog-article__header">
                        <h1 class="blog-article__title">
                            {{ $blog->title }}
                        </h1>
                        <p class="blog-article__meta">
                            <span><i class="fas fa-calendar-day" aria-hidden="true"></i> <time datetime="{{ $published->toDateString() }}">{{ $blog->f_date }}</time></span>
                            <span><i class="fas fa-user" aria-hidden="true"></i> {{ config('app.name') }}</span>
                        </p>
                    </header>

                    @if ($heroSize)
                    <figure class="blog-article__hero">
                        <picture>
                            @if($webp = $blog->webp('1600x650'))
                            <source type="image/webp" srcset="{{ $webp }}">
                            @endif
                            <img src="{{ asset('uploads/blogs/' . $blog->image) }}" alt="{{ $blog->title }}"
                                width="{{ $heroSize[0] }}" height="{{ $heroSize[1] }}" fetchpriority="high">
                        </picture>
                    </figure>
                    @endif

                    <div class="blog-article__body">
                        {!! $blog->details !!}
                    </div>
                </article>
            </div>
            @if($other_blogs->count())
            <div class="col-lg-4">
                <aside class="blog-aside" aria-labelledby="other-blogs-title">
                    <h2 class="blog-aside__title" id="other-blogs-title">Other Blogs</h2>
                    <ul class="blog-aside__list">
                        @foreach ($other_blogs as $b)
                        <li>
                            <a class="blog-aside__item" href="{{ $b->url }}">
                                <img src="{{ $b->image('100x80') }}" alt="" width="100" height="80" loading="lazy" decoding="async">
                                <span class="blog-aside__text">
                                    <span class="blog-aside__item-title">{{ $b->title }}</span>
                                    <time class="blog-aside__date" datetime="{{ ($b->event_date ?? $b->created_at)->toDateString() }}">{{ $b->f_date }}</time>
                                </span>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                    <a class="blog-aside__all" href="{{ url('blogs') }}">All blog posts <i class="fas fa-arrow-right" aria-hidden="true"></i></a>
                </aside>
            </div>
            @endif
        </div>
    </div>
</section>
@endsection
