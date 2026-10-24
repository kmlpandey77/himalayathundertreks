@php($txt = fn ($s) => \Illuminate\Support\Str::squish(html_entity_decode(strip_tags((string) $s), ENT_QUOTES | ENT_HTML5)))
# {{ config('app.name') }}

> {{ config('app.name') }} (Himalaya Thunder Treks & Expedition Pvt. Ltd.) is a government-registered trekking and tour operator based in Thamel, Kathmandu, Nepal. It runs guided treks, tours, peak climbing and adventure trips in Nepal, Tibet and Bhutan, with day-by-day itineraries, fixed departure dates and custom trips.

- Website: {{ url('/') }}
- Email: {{ config('app.email') }}
- Phone / WhatsApp: +977-984-181-6439
- Address: Jyatha, Thamel, Kathmandu 44600, Nepal
- Government registration no.: 87980/068/069
- Prices are quoted in USD. Trips can be booked from each trip page or requested as a customized trip.

@foreach ($activities as $activity)
@if ($activity->tripList->count())
## {!! $txt($activity->title) !!}

@foreach ($activity->tripList as $trip)
- [{!! $txt($trip->title) !!}]({!! $trip->url !!}): {{ $trip->f_duration }}{{ $trip->max_altitude ? ', max altitude ' . $trip->max_altitude : '' }}
@endforeach

@endif
@endforeach
## Company

@foreach ($pages as $page)
- [{!! $txt($page->title) !!}]({{ $page->url }})
@endforeach
- [Guest reviews]({{ url('reviews') }})
- [Contact]({{ url('contact') }})

## Travel guides and articles

@foreach ($blogs as $blog)
- [{!! $txt($blog->title) !!}]({{ $blog->url }})
@endforeach
- [All articles]({{ url('blogs') }})
