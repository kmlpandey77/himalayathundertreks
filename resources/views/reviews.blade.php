@extends('layouts.app')

@section('title', 'Reviews')
@section('meta')
<meta name="description" content="Reviews" >
<meta name="keywords" content="Reviews" >
@endsection

@section('content')

<section class="breadcrubwapper">
    <div class="container">
        {{-- {!! new Breadcrumb($page) !!} --}}
    </div>
</section>

<section class="content gray-bg">
  <div class="container">
  	<div class="content-left inner-review">
  		<section class="overview">
  			<h1>Reviews</h1>
  			<hr>

		      @foreach ($reviews as $review)
		      <div class="media">
						@if ($review->image)
						<img class="align-self-start mr-4 rounded-circle img-thumbnail" src="{{ $review->image_path }}" alt="{{ $review->name }}"  width="100">
						@else
						<img class="align-self-start mr-4 rounded-circle img-thumbnail" src="{{ asset('images/default/user.jpg') }}" alt="{{ $review->name }}"  width="100">
						@endif

				  <div class="media-body">
				    <h5 class="mt-0">{{ $review->title }}</h5>
				    <p class="rating">
				    	@for ($i = 0; $i < $review->rating; $i++)
				    		<i class="fa fa-star active"></i>
							@endfor
							@for ($k = ($i-1); $k < 4; $k++)
				    		<i class="fa fa-star deactive"></i>
				    	@endfor
				    </p>
				    {!! $review->details !!}
				    <p class="name">By <i>{{ $review->name }}, <b>{{ $review->country->name }}</b></i></p>
				  </div>
				</div>
				<hr>
		    @endforeach

		    {{ $reviews->links('vendor.pagination.bootstrap-4') }}
  		</section>
    </div>
  </div>
</section>
@endsection
