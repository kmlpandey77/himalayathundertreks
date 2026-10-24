@php
    // Site-wide entity graph: the business (TravelAgency) and the website. Page schemas
    // (trips, blog posts) reference the business by @id instead of repeating it.
    // Facts here are the ones the site itself publishes (header, footer, social links).
    $orgId = url('/') . '#organization';
    $socials = \Illuminate\Support\Facades\Cache::remember('schema_social_links', now()->addDays(1), function () {
        return \App\Social::active()->pluck('link')->filter()->values()->all();
    });
    $organizationSchema = [
        '@context' => 'https://schema.org',
        '@graph' => [
            [
                '@type' => 'TravelAgency',
                '@id' => $orgId,
                'name' => config('app.name'),
                'legalName' => 'Himalaya Thunder Treks & Expedition Pvt. Ltd.',
                'url' => url('/'),
                'logo' => asset('images/logo.png'),
                'image' => asset('images/logo-square.png'),
                'email' => config('app.email'),
                'telephone' => '+977-984-181-6439',
                'address' => [
                    '@type' => 'PostalAddress',
                    'streetAddress' => 'Jyatha, Thamel',
                    'addressLocality' => 'Kathmandu',
                    'addressRegion' => 'Bagmati',
                    'postalCode' => '44600',
                    'addressCountry' => 'NP',
                ],
                'areaServed' => ['Nepal', 'Tibet', 'Bhutan'],
                'identifier' => [
                    '@type' => 'PropertyValue',
                    'name' => 'Government Registration No.',
                    'value' => '87980/068/069',
                ],
                'sameAs' => $socials,
            ],
            [
                '@type' => 'WebSite',
                '@id' => url('/') . '#website',
                'url' => url('/'),
                'name' => config('app.name'),
                'inLanguage' => 'en',
                'publisher' => ['@id' => $orgId],
            ],
        ],
    ];
@endphp
<script type="application/ld+json">{!! json_encode($organizationSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) !!}</script>
