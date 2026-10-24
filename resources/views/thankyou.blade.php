@extends('layouts.app')

{{-- Not for search results: form confirmation. --}}
@section('robots', 'noindex, follow')

@section('title')
Thank you
@endsection

@section('meta')
<meta name="description" content="Thank you" >
<meta name="keywords" content="Thank you" >
@endsection

@section('content')

<section class="content gray-bg">
	<div class="container">
		{{-- {!! new Breadcrumb($page) !!} --}}

		<div class="content-left">
			<h1>Thank you</h1>

			<p>{{ $msg ? $msg : 'Your request successfully send. We will respond after your request is reviewed.' }}</p>

			</div>

	  <div class="row">
		<div class="col-sm-9">
		</div>
	  </div>
	</div>
  </section>
@endsection
