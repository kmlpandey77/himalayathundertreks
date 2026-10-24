@php
    // Trip page structured data. TouristTrip carries the day-by-day itinerary (useful to search and
    // AI answer engines); a Product node is added only when there is a real price or real ratings.
    // Ratings come from this trip's own approved reviews; nothing is invented.
    $orgId = url('/') . '#organization';
    $tripUrl = $package->url;
    $images = $package->slides->map(fn ($slide) => $slide->image_path)->filter()->values()->all();
    if (! $images && $package->image) {
        $images[] = $package->image_path;
    }
    $price = (float) $package->usd_price;

    $itinerary = $package->itineraries->values()->map(fn ($day, $i) => [
        '@type' => 'ListItem',
        'position' => $i + 1,
        'name' => (preg_match('/^\s*day\b/i', (string) $day->day) ? trim($day->day) : 'Day ' . trim($day->day))
            . ': ' . \Illuminate\Support\Str::squish(strip_tags((string) $day->outline)),
    ])->all();

    $trip = [
        '@type' => 'TouristTrip',
        '@id' => $tripUrl . '#trip',
        'name' => $package->title,
        'description' => $package->m_description,
        'url' => $tripUrl,
        'image' => $images,
        'provider' => ['@id' => $orgId],
    ];
    if ($itinerary) {
        $trip['itinerary'] = ['@type' => 'ItemList', 'numberOfItems' => count($itinerary), 'itemListElement' => $itinerary];
    }

    $offer = $price > 0 ? [
        '@type' => 'Offer',
        'price' => $price,
        'priceCurrency' => 'USD',
        'availability' => 'https://schema.org/InStock',
        'url' => route('booking', $package->slug),
        'seller' => ['@id' => $orgId],
    ] : null;
    if ($offer) {
        $trip['offers'] = $offer;
    }

    $ratings = $package->reviews()->where('status', 1)->whereBetween('rating', [1, 5])->pluck('rating');
    $graph = [$trip];

    if ($offer || $ratings->count()) {
        $facts = [['name' => 'Duration', 'value' => $package->days()]];
        if ($package->max_altitude) {
            $facts[] = ['name' => 'Maximum altitude', 'value' => $package->max_altitude];
        }
        $product = [
            '@type' => 'Product',
            '@id' => $tripUrl . '#product',
            'name' => $package->title,
            'description' => $package->m_description,
            'url' => $tripUrl,
            'image' => $images,
            'brand' => ['@id' => $orgId],
            'additionalProperty' => array_map(fn ($f) => ['@type' => 'PropertyValue'] + $f, $facts),
        ];
        if ($offer) {
            $product['offers'] = $offer;
        }
        if ($ratings->count()) {
            $product['aggregateRating'] = [
                '@type' => 'AggregateRating',
                'ratingValue' => round($ratings->avg(), 1),
                'reviewCount' => $ratings->count(),
                'bestRating' => 5,
                'worstRating' => 1,
            ];
        }
        $graph[] = $product;
    }

    $tripSchema = ['@context' => 'https://schema.org', '@graph' => $graph];
@endphp
<script type="application/ld+json">{!! json_encode($tripSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) !!}</script>
