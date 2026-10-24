<div class="col-sm-6">
    <div class="trip-box">
        <div class="trip_body d-md-flex">
            <div class="trip-img">
                <a href="{{ $package->url}}" class="image" data-background-image="{{ $package->image_path }}"></a>
            </div>
            <div class="trip-txt">
                <h3><a href="{{ $package->url}}">{{ $package->title }}</a></h3>
                <p>{{ Str::limit(strip_tags($package->details),100) }}</p>
            </div>
        </div>

        <div class="trip-fact">
            <ul class="row">
                <li class="col">
                    <span>
                        <i class="fas fa-fw fa-chart-area"></i>
                        {{ config('grade.title.' . $package->grade) }}
                    </span>
                </li>
                <li class="col">
                    <span>
                        <i class="fas fa-fw fa-clock"></i>
                        {{ $package->days() }}
                    </span>
                </li>
                @if($package->price)
                <li class="col">
                    <span>
                        <i class="fas fa-fw fa-tags"></i>
                        US$ <b>{{$package->price}}</b>
                    </span>
                </li>
                @elseif($package->max_altitude)
                <li class="col">
                    <span>
                        <i class="fas fa-fw fa-chart-bar"></i>
                        {{$package->max_altitude}}
                    </span>
                </li>
                @endif
                <li class="col-12 col-md-3 more">
                    <a href="{{ $package->url }}">
                        View Details
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>