@php
    // $homeRow: the homepage shows three cards; hide the third in the two-column tablet layout so the row doesn't orphan.
    // $headingTag: h2 on the blog listing (under the page h1), h3 inside the homepage section (under its h2).
    $headingTag = $headingTag ?? 'h2';
    $published = $blog->event_date ?? $blog->created_at;
    $excerpt = Str::limit(Str::squish(html_entity_decode(strip_tags($blog->details), ENT_QUOTES | ENT_HTML5)), 140, '…', preserveWords: true);
    $excerpt = preg_replace('/[\s.,;:!?]+…$/u', '…', $excerpt); // "nature.…" -> "nature…"
@endphp
<div class="col-md-6 col-lg-4 d-flex {{ !empty($homeRow) && $key == 2 ? 'd-md-none d-lg-flex' : '' }}">
    <article class="blog-card">
        <div class="blog-card__media">
            <img src="{{ $blog->thumb_image }}" alt="" width="400" height="300" loading="lazy" decoding="async">
        </div>
        <div class="blog-card__body">
            <{{ $headingTag }} class="blog-card__title">
                <a href="{{ $blog->url }}">{{ $blog->title }}</a>
            </{{ $headingTag }}>
            <p class="blog-card__meta">
                <span><i class="fas fa-calendar-day" aria-hidden="true"></i> <time datetime="{{ $published->toDateString() }}">{{ $blog->f_date }}</time></span>
                <span><i class="fas fa-user" aria-hidden="true"></i> {{ config('app.name') }}</span>
            </p>
            @if($excerpt)
            <p class="blog-card__excerpt">{{ $excerpt }}</p>
            @endif
            <span class="blog-card__more" aria-hidden="true">Read more <i class="fas fa-arrow-right"></i></span>
        </div>
    </article>
</div>
