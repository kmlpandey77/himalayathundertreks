<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>@yield('title', 'Dashboard') - {{ config('app.name') }} . ITVilla </title>
    <link rel="stylesheet" href="{{ asset('vendors/jquery-ui/jquery-ui.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/backdo0r/icon/style.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/simplebar/simplebar.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/backdo0r/stylesheets/style.css') }}">
    <link rel="icon" href="{{ asset('vendors/backdo0r/images/favicon.ico') }}" type="image/x-icon"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style type="text/css">
        * {
            margin: 0;
            padding: 0;
        }

        .rate {
            float: left;
            height: 46px;
            padding: 0 10px;
        }

        .rate:not(:checked) > input {
            position: absolute;
            top: -9999px;
        }

        .rate:not(:checked) > label {
            float: right;
            width: 1em;
            overflow: hidden;
            white-space: nowrap;
            cursor: pointer;
            font-size: 30px;
            color: #ccc;
        }

        .rate:not(:checked) > label:before {
            content: '★ ';
        }

        .rate > input:checked ~ label {
            color: #ffc700;
        }

        .rate:not(:checked) > label:hover,
        .rate:not(:checked) > label:hover ~ label {
            color: #deb217;
        }

        .rate > input:checked + label:hover,
        .rate > input:checked + label:hover ~ label,
        .rate > input:checked ~ label:hover,
        .rate > input:checked ~ label:hover ~ label,
        .rate > label:hover ~ input:checked ~ label {
            color: #c59b08;
        }
    </style>
</head>

<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top">

    <a class="navbar-brand" href="{{ route('admin.dashboard') }}">
        <img src="{{ asset('images/logo.png') }}" alt="" class="img-responsive"/>
    </a>

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav"
            aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
        <div class="side-bar align-middle" id="side-bar">
            <ul>
                <li><a href="{{ route('admin.dashboard') }}"><i class="lnr lnr-home"></i> <span>Dashboard</span></a>
                </li>
                <li><a href="{{ route('pages.index') }}"><i class="lnr lnr-book"></i> <span>Page</span></a></li>
                <li><a href="{{ route('menus.index') }}"><i class="lnr lnr-menu"></i> <span>Menu</span></a></li>
                <li><a href="{{ route('slides.index') }}"><i class="lnr lnr-picture"></i> <span>Slide</span></a></li>
                <li><a href="{{ route('destinations.index') }}"><i class="lnr lnr-earth"></i> <span>Destinations</span></a>
                </li>
                <li><a href="{{ route('activities.index') }}"><i class="lnr lnr-briefcase"></i> <span>Activities</span></a>
                </li>
                <li><a href="{{ route('regions.index') }}"><i class="lnr lnr-list"></i> <span>Regions</span></a></li>
                <li><a href="{{ route('packages.index') }}"><i class="lnr lnr-map-marker"></i> <span>Packages</span></a>
                </li>
                <li><a href="{{ route('tags.index') }}"><i class="lnr lnr-tag"></i> <span>Tags</span></a></li>
                <li><a href="{{ route('blogs.index') }}"><i class="lnr lnr-bold"></i> <span>Blogs</span></a></li>
                <li><a href="{{ route('albums.index') }}"><i class="lnr lnr-picture"></i> <span>Photo Gallery</span></a>
                </li>
                <li><a href="{{ route('reviews.index') }}"><i class="lnr lnr-bubble"></i> <span>Review</span></a></li>
                <li><a href="{{ route('teams.index') }}"><i class="lnr lnr-mustache"></i> <span> Our team</span></a>
                </li>
                <li><a href="{{ route('legaldocs.index') }}"><i class="lnr lnr-license"></i>
                        <span> Legal Docs</span></a></li>
                <li><a href="{{ route('socials.index') }}"><i class="lnr lnr-link"></i> <span>Social</span></a></li>
                <li><a href="{{ route('associates.index') }}"><i class="lnr lnr-link"></i> <span>Associate</span></a>
                </li>
                <li><a href="{{ route('labels.index') }}"><i class="lnr lnr-spell-check"></i> <span>Label</span></a>
                </li>
                <li><a href="{{ route('redirects.index') }}"><i class="lnr lnr-pointer-right"></i><span>Redirect</span></a>
                </li>
                <li><a href="{{ route('subscribers.index') }}"><i class="lnr lnr-users"></i><span>Subscriber</span></a>
                </li>
                <li><a href="{{ route('newsletters.index') }}"><i
                                class="lnr lnr-envelope"></i><span>Newsletter</span></a></li>
            </ul>
        </div>
        <ul class="navbar-nav ml-auto header_right">
            <li class="name"><b>{{ Auth::user()->name }}</b></li>
            <li><a data-method="post" href="{{ route('cache-clear') }}">Cache Clear</a></li>
            <li><a href="{{ route('settings.index') }}"> <i class="lnr lnr-cog"></i> Setting</a></li>
            <li class="logout"><a data-method="post" href="{{ route('logout') }}"> Logout <i class="lnr lnr-exit"></i></a></li>
        </ul>
    </div>
</nav>
<div class="content">

    <div class="row">
        <div class="col">
            <h1>@yield('title', 'Dashboard')</h1>
        </div>
        <div class="col-auto pt-4">@yield('actionbtn')</div>
    </div>
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if(Session::has('success'))
        <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {{ Session::get('success') }}
        </div>
    @endif
    @if(Session::has('error'))
        <div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {{ Session::get( 'error') }}
        </div>
    @endif

    @yield('content')

</div>

<div class="footer">
    <p>2013 -
        <?php echo date("Y"); ?>, © & Power by: <a href="https://w3web.co.uk/" target="_blank">W3 Web Technology</a></p>
</div>

<div class="modal fade" id="jsModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <p>Loading...</p>
        </div>
    </div>
</div>

<script>
    // Links marked data-method="post" (show/hide, delete, cache clear, logout) change data,
    // so they are sent as POST with the CSRF token instead of a plain GET.
    document.addEventListener('click', function (e) {
        var link = e.target.closest('a[data-method="post"]');
        if (!link || e.defaultPrevented) return; // defaultPrevented: an inline confirm() was cancelled
        e.preventDefault();
        var form = document.createElement('form');
        form.method = 'POST';
        form.action = link.href;
        form.style.display = 'none';
        var token = document.createElement('input');
        token.type = 'hidden';
        token.name = '_token';
        token.value = document.querySelector('meta[name="csrf-token"]').content;
        form.appendChild(token);
        document.body.appendChild(form);
        form.submit();
    });
</script>
<script src="{{ asset('vendors/jquery-ui/external/jquery/jquery.js') }}"></script>
<script src="{{ asset('vendors/jquery-ui/jquery-ui.min.js') }}"></script>
<script src="{{ asset('vendors/popper.min.js') }}"></script>
<script src="{{ asset('vendors/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('vendors/simplebar/simplebar.js') }}"></script>
<script src="{{ asset('vendors/loadingoverlay.min.js') }}"></script>
<script src="{{ asset('vendors/backdo0r/custom.js') }}"></script>
<script src="{{ asset('vendors/backdo0r/ckeditor/ckeditor.js') }}"></script>
<script>
    // CKEDITOR.replace( 'details' );
    CKEDITOR.replace('details', {
        // extraPlugins: 'imageuploader',
        // allowedContent: true,
        extraPlugins: 'autoembed,embed,image2',
        embed_provider: '//ckeditor.iframe.ly/api/oembed?url={url}&callback={callback}',
        filebrowserImageBrowseUrl: '/filemanager?type=Images',
        filebrowserImageUploadUrl: '/filemanager/upload?type=Images&_token=' + '{{ csrf_token() }}',
        filebrowserBrowseUrl: '/filemanager?type=Files',
        filebrowserUploadUrl: '/filemanager/upload?type=Files&_token=' + '{{ csrf_token() }}'
    });
    CKEDITOR.replace('include');
    CKEDITOR.replace('exclude');
    CKEDITOR.replace('highlight');
    CKEDITOR.replace('itinerary_note');
    CKEDITOR.replace('trip_details');
    CKEDITOR.replace('price_details');
    // $('.detail_itineray').each( function () {
    // 	CKEDITOR.replace( this.id);
    // });
</script>

<script>
    $(function () {
        $('.topbar').dropdown();
        $('[data-toggle="tooltip"]').tooltip();
    });
    $(function () {
        // $(".datepicker").datepicker({
        // 	changeMonth: true,
        // 	changeYear: true,
        // 	dateFormat: 'yy-mm-dd'
        // });
        $(".datepicker").datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: 'yy-mm-dd',
            minDate: 0,
            onSelect: function (date) {

                var selectedDate = new Date(date);
                var msecsInADay = 86400000;
                var endDate = new Date(selectedDate.getTime() + msecsInADay);

                $(".deparute_date").datepicker("option", "minDate", endDate);
            }
        });

        $(".deparute_date").datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: 'yy-mm-dd',
            minDate: 0,
        });
    });
</script>
@yield('script')
</body>

</html>