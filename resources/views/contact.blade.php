@extends('layouts.app')
@section('title') {{ $page->m_title }}
@endsection

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
<section class="content gray-bg {{ $page->slug }}">
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <section class="overview">
                    <h1>
                        {{ $page->title }}
                    </h1>

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    <form action="{{ route('contact') }}" method="post">
                        {!! csrf_field() !!}
                        <div class="form-group">
                            <label for="name">
                                Name
                            </label>
                            <input class="form-control" id="name" name="name" placeholder="Enter name" required="required" type="text"/>
                        </div>
                        <div class="form-group">
                            <label for="email">
                                Email Address
                            </label>
                            <input class="form-control" id="email" name="email" placeholder="Enter email" required="required" type="email"/>
                        </div>
                        <div class="form-group">
                            <label for="phone">
                                Phone
                            </label>
                            <input class="form-control" id="phone" name="phone" placeholder="Enter phone" type="text"/>
                        </div>
                        <div class="form-group">
                            <label for="name">
                                Message
                            </label>
                            <textarea class="form-control" cols="25" id="message" name="message" placeholder="Message" required="required" rows="9"></textarea>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-2">
                                <img src="{{ route('captchaimage') }}" alt="Captcha">
                            </div>

                            <div class="col-md-10">
                                <input type="text" class="form-control {{ $errors->has('captcha') ? ' is-invalid' : '' }}" id="captcha" name="captcha" placeholder="Enter Captcha">
                                @if ($errors->has('captcha'))
                                    <span class="help-block text-danger"><strong>{{ $errors->first('captcha') }}</strong></span>
                                @endif
                            </div>
                        </div>
                        <button class="button button-primary" type="submit">
                            Send Message
                        </button>
                    </form>
                </section>
            </div>
            <div class="col-sm-6">
                <div class="content-right">
                    {!! $page->details !!}
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
