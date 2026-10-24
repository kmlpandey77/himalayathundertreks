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
            <h1>
                {{ $page->title }}
            </h1>
            @if ($blogs->count())
            <div class="row">
                @foreach ($blogs as $key=>$blog)
                    @include('blog.card')
                @endforeach
                {{ $blogs->links() }}
            @else
                <p>
                    No record found!!
                </p>
            </div>
            @endif
        </section>
    </div>
</section>
@endsection
