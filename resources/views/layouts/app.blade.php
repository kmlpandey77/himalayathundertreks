<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="x-dns-prefetch-control" content="on">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', config('app.name'))</title>

    <meta name="msvalidate.01" content="0AE3F6C76C23003B587A5B051F176AC0" />
    <meta name="yandex-verification" content="1edbc176edabc55c" />

    <meta name="robots" content="@yield('robots', 'index, follow, max-image-preview:large, max-snippet:-1')">
    <meta property="og:type" content="@yield('og_type', 'website')" />
    <meta property="og:url" content="{{ request()->url() }}" />
    <meta property="og:site_name" content="{{ config('app.name') }}" />
    <meta name="twitter:card" content="summary_large_image" />

    @yield('meta')

    <meta name="allow-search" content="yes" />
    <meta name="AGLSTERMS.allow-search" content="yes">
    <meta name="rating" content="Recreation, Travel, Outdoor, Adventure, Holidays, Trekking in Nepal">
    <meta name="category" content="Recreation, Adventure, Outdoor, Travel, Holidays and Tourism" />
    <meta name="classification" content="Recreation, Travel, Outdoor, Adventure, Holidays" />
    <meta name="dcterms.rights" content="Copy Rights {{ config('app.name') }}">
    <meta name="copyright" content="copy rights {{ config('app.name') }}" />
    <meta name="dcterms.dateCopyrighted" content="{{ date('Y') }}">
    <meta name="author" content=" {{ config('app.name') }} " />
    <meta name="country" content="worldwide" />
    <meta name="document-type" content="public" />
    <meta name="resource-type" content="document" />
    <meta name="distribution" content="global" />
    <meta http-equiv="bulletin-text" content="Travel and Tourism" />

    <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('images/apple-icon-57x57.png') }}">
    <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('images/apple-icon-60x60.png') }}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('images/apple-icon-72x72.png') }}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('images/apple-icon-76x76.png') }}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('images/apple-icon-114x114.png') }}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('images/apple-icon-120x120.png') }}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('images/apple-icon-144x144.png') }}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('images/apple-icon-152x152.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/apple-icon-180x180.png') }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('images/android-icon-192x192.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('images/favicon-96x96.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('images/manifest.json') }}">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="{{ asset('images/ms-icon-144x144.png') }}">
    <meta name="theme-color" content="#ffffff">

    {{-- Paginated lists keep their page number (page 2 is not a duplicate of page 1). --}}
    @php($pageNumber = (int) request()->query('page', 1))
    <link rel="canonical" href="@yield('canonical', request()->url() . ($pageNumber > 1 ? '?page=' . $pageNumber : ''))">


    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
    href="https://fonts.googleapis.com/css?family=Montserrat:400,500,600|Poppins:400,500,600,700&display=swap"
    rel="stylesheet">

    {!! new Minify('css') !!}
    @stack('styles')


    @include('seo.organization')
    @yield('schema')
    </head>

    <body>
        @include('inc/header')
        @include('inc/navbar')
        @yield('content')
        @include('inc/footer')

    {!! new Minify('js') !!}

    @yield('script')

    
<!--Start of Tawk.to Script-->
<script type="text/javascript">
    var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
    (function(){
    var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
    s1.async=true;
    s1.src='https://embed.tawk.to/5e469b78298c395d1ce7f2d4/default';
    s1.charset='UTF-8';
    s1.setAttribute('crossorigin','*');
    s0.parentNode.insertBefore(s1,s0);
    })();
    </script>
    <!--End of Tawk.to Script-->


  

</body>

</html>