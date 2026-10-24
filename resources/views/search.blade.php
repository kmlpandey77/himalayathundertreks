@extends('layouts.app')

@section('title')
Search Result
@endsection


@section('content')

<section class="content gray-bg">
	<div class="container">
		<form action="{{ route('search') }}">
                <div class="row">
                    <div class="col-sm">
                        <div class="form-group">
                            <label>Destination</label>
                            <select class="custom-select" name="destination" id="">
                                <option value="0">Select destination</option>
                                @foreach($destinations as $destination)
                                    <option value="{{ $destination->id }}" {{ isset($destination) ? 'selected=selected' : null }}>{{ $destination->title }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="form-group">
                            <label>Activity</label>
                            <select class="custom-select" name="activity" id="">
                                <option value="0">Select Activity</option>
                                @foreach($activities as $activity)
                                    <option value="{{ $activity->id }}" {{ isset($activity) ? 'selected=selected' : null }}>{{ $activity->title }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="form-group">
                            <label>Duration</label>
                            <select class="custom-select" name="duration" id="">
                                <option value="0">Select duration</option>
                                <option value="1">Day Trip</option>
                                <option value="2">2-7 Days</option>
                                <option value="3">8-14 Days</option>
                                <option value="4">15-21 Days</option>
                                <option value="5">Above 22 Days</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <button class="button button-secondary button-pill">Search</button>
                </div>
            </form>
		<div class="content-left">

			<h1>Search Result</h1>
			<div class="card-list">

			@if (count($packages) > 0)
			<div class="row">
				@foreach ($packages as $package)
				@php
				$package = \App\Package::find($package->id);
				@endphp
				@include('package-card')
				@endforeach
			</div>

			<hr>
			{{ $packages->appends(request()->all())->links('vendor.pagination.bootstrap-4') }}
			@else
			<p>Your search did not match any documents.</p>
			@endif
			</div>


		</div>

	</div>
</section>

@endsection


