@extends('layouts.app')

@section('title')
{{ $page->meta_title() }}
@endsection

@section('meta')
<meta content="{{ $page->meta_description() }}" name="description"/>
<meta content="{{ $page->meta_keyword() }}" name="keywords"/>
@endsection

@section('content')
<div class="inner-page white-bg">
    <div class="container">
        {!! new Breadcrumb($page) !!}
        <div class="row">
            <div class="col-sm-8">
                <div class="page-overview {{ $page->slug }}">
                    <h1>
                        {{ $page->title }}
                    </h1>
                    <div aria-multiselectable="true" class="panel-group" id="accordion" role="tablist">
                        @if (count($faqs) > 1)
                        @foreach ($faqs as $key => $faq)
                        <div class="panel panel-default">
                            <div class="panel-heading" id="headingOne" role="tab">
                                <h4 class="panel-title">
                                    <a aria-controls="collapse_{{ $key }}" aria-expanded="true" data-parent="#accordion" data-toggle="collapse" href="#collapse_{{ $key }}" role="button">
                                        {{ $faq['question'] }}
                                    </a>
                                </h4>
                            </div>
                            <div aria-labelledby="headingOne" class="panel-collapse collapse {{ $key==1 ? 'in' : null }}" id="collapse_{{ $key }}" role="tabpanel">
                                <div class="panel-body">
                                    {!! $faq['answer'] !!}
                                </div>
                            </div>
                        </div>
                        @endforeach
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="right-box">
                    <h3>
                        Travel Blog
                    </h3>
                    <ul class="travel-blog">
                        @foreach ($blogs as $blog)
                        <li>
                            <a href="{{ url('blog/'.$blog->slug) }}">
                                <div class="image">
                                    <img alt="{{ $blog->title }}" src="{{ $blog->thumb() }}">
                                    </img>
                                </div>
                                <div class="text">
                                    <span class="date">
                                        {{ $blog->event_date() }}
                                    </span>
                                    <h4 class="title">
                                        {{ $blog->title}}
                                    </h4>
                                </div>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
                <div class="right-box">
                    <div class="tripadvisor">
                        <div class="TA_selfserveprop" id="TA_selfserveprop364">
                            <ul class="TA_links wG7mFrGhBn" id="TVXN4dbf">
                                <li class="ptLmPB1Z1To" id="ugdTFYgaopcW">
                                    <a href="https://www.tripadvisor.com/" target="_blank">
                                        <img alt="TripAdvisor" src="https://www.tripadvisor.com/img/cdsi/img2/branding/150_logo-11900-2.png"/>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <script src="https://www.jscache.com/wejs?wtype=selfserveprop&uniq=364&locationId=10897806&lang=en_US&rating=true&nreviews=3&writereviewlink=true&popIdx=false&iswide=false&border=true&display_version=2">
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
