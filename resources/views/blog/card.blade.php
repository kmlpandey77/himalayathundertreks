<div class="col-md-6 col-lg-4 {{ $key==2 ? 'd-md-none d-lg-block':null }}">
    <div class="blog-col mb-4">
        <a href="{{ $blog->url }}">
            <img alt="{{ $blog->title }}" class="img-fluid" data-src="{{ $blog->thumb_image }}" title="{{ $blog->title }}" />
        </a>
        <div class="blog-col-txt">
            <h4><a href="{{ $blog->url }}">{{ $blog->title }}</a></h4>
            <p class="date-user">
                <span class="pr-1">
                    <i class="fas fa-calendar-day"></i>
                    {{ $blog->f_date }}
                </span>
                <span>
                    <i class="fas fa-user"></i>
                    {{ config('app.name') }}
                </span>
            </p>
            <p>
                {{ Str::limit(strip_tags($blog->details), 120) }}
                <a href="{{ $blog->url }}">Read More</a>
            </p>
        </div>
    </div>
</div>