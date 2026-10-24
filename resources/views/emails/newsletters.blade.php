@component('vendor.mail.html.message')
#{{ $newsletter->title }}
{{ strip_tags($newsletter->details) }}
@if($newsletter->image)
	<img src="{{ asset('uploads/newsletter/image/'. $newsletter->image) }}" alt="{{ $newsletter->title }}" width="100%">
@endif

@endcomponent