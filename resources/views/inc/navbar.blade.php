<div class="main-menu sticky-top" id="main-menu">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light">
            <a class="navbar-brand mr-5 hide" href="{{ route('home') }}">
                <img src="{{ asset('images/logo.png') }}" alt="{{ config('app.name') }}" width="250">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-main"
                aria-controls="navbar-main" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbar-main">
                <ul class="navbar-nav">
                    {!! App\Menu::html($main_menu) !!}
                </ul>
            </div>
        </nav>
    </div>
</div>