@extends('layouts.app')

@section('meta')
<meta content="Write Review" name="description"/>
<meta content="Write Review" name="keywords"/>
@endsection

@section('title', 'Write Review')

@section('content')
<section class="breadcrubwapper">
    <div class="container">
        <nav itemscope="" itemtype="http://schema.org/BreadcrumbList" aria-label="breadcrumb" class="hidden-xs">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item active">Write Review</li>
            </ol>
        </nav>
    </div>
</section>
<section class="content gray-bg ">
    <div class="container">
        <div class="row">
            <div class="col-sm-8 offset-sm-2">
                <section class="overview">
                    <h1>Write Review</h1>
                    
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('write-review') }}" method="POST">
                        {!! csrf_field() !!}
                        <h3>Personal Details</h3>
                        <div class="form-group">
                            <label class="control-label" for="name">Name</label>
                            <input class="col-md-8 form-control" placeholder="Name" name="name"
                                value="{{ old('name') }}" type="text" id="name">
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="email">Email</label>
                            <input class="col-md-8 form-control" placeholder="Email" name="email"
                                value="{{ old('email') }}" type="text" id="email">
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="country_id">Country</label>
                            <select class="form-control" name="country_id" id="country_id">
                                <option value="">Select Country</option>
                                @foreach ($countries as $country)
                                <option value="{{ $country->id }}"
                                    {{ $country->id == old('country', isset($review) ? $review->country_id : null ) ? 'selected="selected"' : null }}>
                                    {{ $country->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="image">Image</label>
                            <div class="">
                                <input type="file" name="image" id="image">
                            </div>
                        </div>

                        <hr>
                        <br><br>
                        <h3>Review Details</h3>
                        <div class="form-group">
                            <label class="control-label" for="title">Title</label>
                            <input class="col-md-4 form-control" placeholder="Title" name="title"
                                value="{{ old('title', isset($review) ? $review->title : null) }}" type="text" id="title">
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="package_id">Trip</label>
                            <select class="form-control" name="package_id" id="package_id">
                                <option value="0">None (Optional)</option>
                                @foreach ($packages as $package)
                                <option value="{{ $package->id }}"
                                    {{ $package->id == old('package_id', isset($review) ? $review->package_id : null ) ? 'selected="selected"' : null }}>
                                    {{ $package->title }}</option>
                                @endforeach
                            </select>

                        </div>

                        <div class="form-group ">
                            <label class="control-label" for="rating">Rating</label>
                            <select class="form-control" name="rating" id="rating">
                                <option value="1" {{ 1 == old('rating', isset($review) ? $review->rating : null ) ? 'selected="selected"' : null }}>
                                    1
                                </option>
                                <option value="2" {{ 2 == old('rating', isset($review) ? $review->rating : null ) ? 'selected="selected"' : null }}>
                                    2
                                </option>
                                <option value="3" {{ 3 == old('rating', isset($review) ? $review->rating : null ) ? 'selected="selected"' : null }}>
                                    3
                                </option>
                                <option value="4" {{ 4 == old('rating', isset($review) ? $review->rating : null ) ? 'selected="selected"' : null }}>
                                    4
                                </option>
                                <option value="5" {{ 5 == old('rating', isset($review) ? $review->rating : null ) ? 'selected="selected"' : null }}>
                                    5
                                </option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="details">Details</label>
                            <textarea class="form-control" rows="8" placeholder="Details" name="details"
                                id="details">{{ old('details', isset($review) ? $review->details : null) }}</textarea>
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

                        <div class="form-group">
                            <button type="submit" class="button button-primary button-raised button-rounded button-block">Send</button>
                        </div>
                    </form>
                </section>
            </div>
        </div>
    </div>
</section>
@endsection
