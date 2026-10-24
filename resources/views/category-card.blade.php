<div class="col-md-6 col-xl-4">
        <div class="card-box">
      <div class="card-image">
        <a href="{{ $category->url }}"><img src="{{ $category->image() }}" class="img-fluid"></a>
        <h4><a href="{{ $category->url }}">{{ $category->title }}</a></h4>
      </div>
      <div class="card-txt">
          <p>{{ Str::limit(strip_tags($category->details),120) }}</p>
          <a href="{{ $category->url }}" class="button button-secondary button-rounded button-small">Read more</a>
      </div>
    </div>
  </div>