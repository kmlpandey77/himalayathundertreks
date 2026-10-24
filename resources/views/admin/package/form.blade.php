<div class="card-header sticky-top text-right" style="top:70px; background: #F8F9FA;">
	<button type="submit" class="button button-primary button-rounded button-small" name="save_close"
		value="save_close">
		<i class="lnr lnr-inbox"></i> <span>Save & Close</span>
	</button>
	<button type="submit" class="button button-secondary button-rounded button-small" name="save" value="save">
		<i class="lnr lnr-inbox"></i> <span>Save</span>

	</button>
	<a href="{{ route('packages.index', request()->all()) }}"
		class="button button-plain_gray button-rounded button-small"><i class="lnr lnr-exit"></i>
		<span>Cancel</span></a>
</div>
<div class="card-header">
	<ul class="nav nav-pills nav-fill" id="pills-tab" role="tablist">
		<li class="nav-item">
			<a class="nav-link active" id="pills-overview-tab" data-toggle="pill" href="#overview" role="tab"
				aria-controls="pills-home" aria-selected="true">Overview</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" id="pills-trip_facts-tab" data-toggle="pill" href="#trip_facts" role="tab"
				aria-controls="pills-profile" aria-selected="false">Trip Facts</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" id="pills-highlight-tab" data-toggle="pill" href="#highlight_" role="tab"
				aria-controls="pills-contact" aria-selected="false">Highlight</a>
		</li>
		{{-- <li class="nav-item">
			<a class="nav-link" id="pills-price_details-tab" data-toggle="pill" href="#price_details_" role="tab" aria-controls="pills-contact"
			 aria-selected="false">Price Details</a>
		</li> --}}
		<li class="nav-item">
			<a class="nav-link" id="pills-itinerary-tab" data-toggle="pill" href="#itinerary" role="tab"
				aria-controls="pills-contact" aria-selected="false">Itinerary</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" id="pills-inclusion_exclusion-tab" data-toggle="pill" href="#inclusion_exclusion"
				role="tab" aria-controls="pills-contact" aria-selected="false">Inclusion/Exclusion</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" id="pills-trip_details_-tab" data-toggle="pill" href="#trip_details_" role="tab"
				aria-controls="pills-contact" aria-selected="false">Trip Details</a>
		</li>
		{{-- <li class="nav-item">
			<a class="nav-link" id="pills-graph-tab" data-toggle="pill" href="#graph" role="tab" aria-controls="pills-contact" aria-selected="false">Altitude Graph</a>
		</li> --}}
	</ul>

</div>

<div class="card-body">
	<!-- Tab panes -->
	<div class="tab-content">
		<div role="tabpanel" class="tab-pane active" id="overview">
			<div class="form-group row">
				<label class="col-sm-2 col-form-label text-right" for="category_id">Category</label>
				<div class="col-sm-3">
					<select class="form-control" name="category_id" id="category_id">
						<option value="">Select</option>
						@foreach (\App\Activity::all() as $activity)
						<option value="{{ $activity->id }}"
							{{ $activity->id == old('category_id', isset($package) ? $package->category_id : null ) ? 'selected="selected"' : null }}>
							{{ $activity->title }}</option>
						@endforeach
					</select>
				</div>

				<label class="col-sm-2 col-form-label text-right" for="region_id">Region</label>
				<div class="col-sm-3">
					<select class="form-control" name="region_id" id="region_id">
						<option value="">None</option>
						@foreach (\App\Region::all() as $region)
						<option value="{{ $region->id }}"
							{{ $region->id == old('region_id', isset($package) ? $package->region_id : null ) ? 'selected="selected"' : null }}>
							{{ $region->title }}</option>
						@endforeach
					</select>
				</div>
			</div>

			<div class="form-group row">
				<label class="col-sm-2 col-form-label text-right" for="title">Title</label>
				<div class="col-sm-8">
					<input class="form-control" placeholder="Title" name="title"
						value="{{ old('title', isset($package) ? $package->title : null) }}" type="text" id="title">
				</div>
			</div>

			<div class="form-group row">
				<label class="col-sm-2 col-form-label text-right" for="details">Details</label>
				<div class="col-sm-10">
					<textarea class="form-control" rows="8" placeholder="Details" name="details"
						id="details">{{ old('details', isset($package) ? $package->details : null) }}</textarea>
				</div>
			</div>
			<div class="form-group row">
				<label class="col-sm-2 col-form-label text-right" for="image">Thumb Image</label>
				<div class="col-sm-10">
					@if(isset($package) && $package->image && file_exists(public_path('uploads/packages/' .
					$package->image )))
					<img src="{{ asset('uploads/packages/' .$package->image ) }}" alt="" width="200">
					<br><br> @endif
					<input type="file" name="image" id="image"> Image size:
					{{ config('image.trip_thumb.0') }}x{{ config('image.trip_thumb.1') }}px
				</div>
			</div>

			<div class="form-group row">
				<label class="col-sm-2 col-form-label text-right" for="map">Map</label>
				<div class="col-sm-10">
					@if(isset($package) && $package->map && file_exists(public_path('uploads/maps/' . $package->map )))
					<img src="{{ asset('uploads/maps/' .$package->map ) }}" alt="" width="200">
					<br><br> @endif
					<input type="file" name="map" id="map">
				</div>
			</div>

			<div class="form-group row">
				<label class="col-sm-2 col-form-label text-right" for="video_url">Video Url (Youtube)</label>
				<div class="col-sm-8">
					<input class="form-control" placeholder="Title" name="video_url"
						value="{{ old('video_url', isset($package) ? $package->video_url : null) }}" type="text" id="title">
				</div>
			</div>

			<div class="form-group row">
				<label class="col-sm-2 col-form-label text-right" for="meta_title">Meta title</label>
				<div class="col-sm-10">
					<textarea class="col-md-8 form-control" rows="4" placeholder="Meta title" name="meta_title"
						id="meta_title">{{ old('meta_title', isset($package) ? $package->meta_title : null) }}</textarea>
				</div>
			</div>
			<div class="form-group row">
				<label class="col-sm-2 col-form-label text-right" for="meta_description">Meta description</label>
				<div class="col-sm-10">
					<textarea class="col-md-8 form-control" rows="4" placeholder="Meta description"
						name="meta_description"
						id="meta_description">{{ old('meta_description', isset($package) ? $package->meta_description : null) }}</textarea>
				</div>

			</div>
			<div class="form-group row">
				<label class="col-sm-2 col-form-label text-right" for="meta_keyword">Meta keyword</label>
				<div class="col-sm-10">
					<textarea class="col-md-8 form-control" rows="4" placeholder="Meta keyword" name="meta_keyword"
						id="meta_keyword">{{ old('meta_keyword', isset($package) ? $package->meta_keyword : null) }}</textarea>
				</div>
			</div>
			<div class="form-group row">
				<div class="col-sm-3 offset-sm-2">
					<div class="checkbox">
						<label>
							<input type="checkbox" name="status" id="status" value="1"
								{{ old('status', isset($package) ? $package->status : 1) == 1 ? 'checked=checked' : null  }}>
							Active
						</label>
					</div>
				</div>
			</div>
			<div class="form-group row">
				<div class="col-sm-2"></div>
				@foreach($tags as $tag)
				<div class="col-sm">
					<div class="checkbox">
						<label>
							<input type="checkbox" name="tags[]" class="type" id="tags" value="{{ $tag->id }}"
								{{ is_array(old('tags', isset($package) ? $package->tags()->allRelatedIds()->toArray():null)) && in_array($tag->id, old('tags', isset($package) ? $package->tags()->allRelatedIds()->toArray():null)) ? 'checked=checked': null }}>
							{{ $tag->title }}
						</label>
					</div>
				</div>
				@endforeach
			</div>
		</div>
		<div role="tabpanel" class="tab-pane" id="trip_facts">
			<div class="form-group row">
				<label class="col-sm-2 col-form-label text-right" for="price1_pax">1 Pax</label>
				<div class="col-sm-4">
					@if(isset($package))
						@php $first = App\Price::where('package_id',$package->id)->where('title','1 Pax')->first(); @endphp
					@endif
					<input class="form-control" placeholder="1 Pax Price" name="price1_pax" value="{{ old('price1_pax', isset($package) && $first ? $first->value : null) }}" type="number" step="0.01" id="price1_pax">
				</div>
				<div class="col-sm-4">
					(USD)
				</div>
			</div>

			<div class="form-group row">
				<label class="col-sm-2 col-form-label text-right" for="price2_pax">2 - 3 Pax</label>
				<div class="col-sm-4">
					@if(isset($package))
						@php $second = App\Price::where('package_id',$package->id)->where('title','2 - 3 Pax')->first(); @endphp
					@endif
					<input class="form-control" placeholder="2 - 3 Pax Price" name="price2_pax" value="{{ old('price2_pax', isset($package) && $second ? $second->value : null) }}" type="number" step="0.01" id="price2_pax">
				</div>
				<div class="col-sm-4">
					(USD)
				</div>
			</div>

			<div class="form-group row">
				<label class="col-sm-2 col-form-label text-right" for="price3_pax">4 - 7 Pax</label>
				<div class="col-sm-4">
					@if(isset($package))
						@php $third = App\Price::where('package_id',$package->id)->where('title','4 - 7 Pax')->first(); @endphp
					@endif
					<input class="form-control" placeholder="4 - 7 Pax Price" name="price3_pax" value="{{ old('price3_pax', isset($package) && $third ? $third->value : null) }}" type="number" step="0.01" id="price3_pax">
				</div>
				<div class="col-sm-4">
					(USD)
				</div>
			</div>

			<div class="form-group row">
				<label class="col-sm-2 col-form-label text-right" for="price4_pax">8+ Pax</label>
				<div class="col-sm-4">
					@if(isset($package))
						@php $fourth = App\Price::where('package_id',$package->id)->where('title','8+ Pax')->first(); @endphp
					@endif
					<input class="form-control" placeholder="8+ Pax Price" name="price4_pax" value="{{ old('price4_pax', isset($package) && $fourth ? $fourth->value : null) }}" type="number" step="0.01" id="price4_pax">
				</div>
				<div class="col-sm-4">
					(USD)
				</div>
			</div>

			<div class="form-group row">
				<label class="col-sm-2 col-form-label text-right" for="duration">Duration</label>
				<div class="col-sm-4">
					<input class="form-control" placeholder="Duration" name="duration"
						value="{{ old('duration', isset($package) ? $package->duration : null) }}" type="text"
						id="duration">
				</div>
				<div class="col-sm-4">
					Day(s)
				</div>
			</div>
			<div class="form-group row">
				<label class="col-sm-2 col-form-label text-right" for="grade">Grade</label>
				<div class="col-sm-4">
					<select name="grade" id="" class="form-control">
						<option value="">Select</option>
						@foreach (config('grade.title') as $id => $grade)
						<option
							{{ $id == old('grade', isset($package) ? $package->grade : null) ? 'selected="selected"' : null  }}
							value="{{ $id }}">{{ $grade }}</option>
						@endforeach
					</select>
				</div>
			</div>

			<h4>Others</h4>

			@if (isset($package) && $package->facts)
			<div id="factsortable">
				@foreach ($package->facts as $fact)
				<div class="form-group row" id="{{ $fact->id }}">
					<div class="col-sm-4">
						<input name="facts_edit[id][]" value="{{ $fact->id }}" type="hidden">
						<input class="form-control" placeholder="Title" name="facts_edit[title][]"
							value="{{ $fact->title }}" type="text" id="">
					</div>
					<div class="col-sm-4">
						<input class="form-control" placeholder="Value" name="facts_edit[value][]"
							value="{{ $fact->value }}" type="text" id="">
					</div>
					<div class="col-sm-4">
						{{-- <button type="button" class="btn btn-warning fact_grag"><span class="lnr lnr-list"></span></button> --}}
						<button type="button" class="btn btn-danger fact_delete" data-id="{{ $fact->id }}"><span
								class="lnr lnr-trash"></span></button>
					</div>
				</div>
				@endforeach
			</div>
			@endif

			<div id="facts_wrap">
				<div class="form-group row last">
					<div class="col-sm-4">
						<input class="form-control" placeholder="Title" name="facts[title][]" value="" type="text"
							id="grade">
					</div>
					<div class="col-sm-4">
						<input class="form-control" placeholder="Value" name="facts[value][]" value="" type="text"
							id="grade">
					</div>
				</div>
			</div>
			<div class="form-group row">
				<div class="col-sm-3"><button type="button" class="btn btn-primary btn-sm btn-block"
						onclick="fact_add_another()"> Add Another</button></div>
			</div>

		</div>

		<div role="tabpanel" class="tab-pane" id="itinerary">
			@php $last_day = 0;
			@endphp @if (isset($package) && $package->itineraries)
			<a href="{{ route('packages.viewitinerary', $package->id) }}" class="btn btn-info js-modal-call"><i
					class="lnr lnr-list"></i> Change Itinerary Order</a>
			<hr>
			<div class="clearfix"></div>
			@foreach ($package->itineraries as $itinerary)
			<div class="form-group row">
				<div class="col-sm-2">
					<input name="itinerary_edit[id][]" value="{{ $itinerary->id }}" type="hidden">
					<input class="form-control" placeholder="Day" name="itinerary_edit[day][]"
						value="{{ $itinerary->day }}" type="text" id="day">
				</div>
				<div class="col-sm-10">
					<div class="form-group row">
						<div class="col-sm-11">
							<input class="form-control" placeholder="Outline" name="itinerary_edit[outline][]"
								value="{{ $itinerary->outline }}" type="text">
						</div>
						<div class="col-sm-1">
							<a href="{{ route('packages.itinerarydelete', $itinerary->id) }}" class="btn btn-danger"
								onclick="return confirm('Are your sure?')"><i class="lnr lnr-trash"></i></a>
						</div>
					</div>

					<div class="form-group row">
						<div class="col-sm-12">
							<textarea class="form-control detail_itineray" placeholder="Details"
								id="detail_itineray_{{ $itinerary->day }}"
								name="itinerary_edit[details][]">{{ $itinerary->details }}</textarea>
						</div>
					</div>

					<div class="form-group row">
						<div class="col-sm-4">
							<input class="form-control" placeholder="Hour" name="itinerary_edit[hour][]"
								value="{{ $itinerary->hour }}" type="text">
						</div>
						<div class="col-sm-4">
							<input class="form-control" placeholder="Accommodation"
								name="itinerary_edit[accommodation][]" value="{{ $itinerary->accommodation }}"
								type="text">
						</div>
						<div class="col-sm-4">
							<input class="form-control" placeholder="Meal" name="itinerary_edit[meal][]"
								value="{{ $itinerary->meal }}" type="text">
						</div>
					</div>

				</div>
			</div>
			@php $last_day = filter_var($itinerary->day, FILTER_SANITIZE_NUMBER_INT);
			@endphp @endforeach @endif @php $last_day = $last_day
			+ 1;
			@endphp
			<div id="itinerary_wrap">
				<div class="form-group row last">
					<div class="col-sm-2">
						<input class="form-control" placeholder="Day" name="itinerary[day][]"
							value="Day {{ $last_day }}" type="text" id="day">
					</div>
					<div class="col-sm-10">
						<div class="form-group row">
							<div class="col-sm-12">
								<input class="col-md-4 form-control" placeholder="Outline" name="itinerary[outline][]"
									value="" type="text">
							</div>
						</div>

						<div class="form-group row">
							<div class="col-sm-12">
								<textarea class="form-control" placeholder="Details" id=""
									name="itinerary[details][]"></textarea>
							</div>
						</div>

						<div class="form-group row">
							<div class="col-sm-4">
								<input class="form-control" placeholder="Hour" name="itinerary[hour][]" value=""
									type="text">
							</div>
							<div class="col-sm-4">
								<input class="form-control" placeholder="Accommodation"
									name="itinerary[accommodation][]" value="" type="text">
							</div>
							<div class="col-sm-4">
								<input class="form-control" placeholder="Meal" name="itinerary[meal][]" value=""
									type="text">
							</div>
						</div>

					</div>
				</div>
			</div>
			<div class="form-group row">
				<div class="col-sm-3"><button type="button" class="btn btn-primary btn-sm btn-block"
						onclick="itinerary_add_another()"> Add Another</button></div>
			</div>

			<hr>

			<h5>Note</h5>
			<textarea name="itinerary_note" id="itinerary_note"
				class="form-control">{{ old('include', isset($package) ? $package->itinerary_note: null) }}</textarea>
		</div>

		{{-- <div role="tabpanel" class="tab-pane" id="price_details_">
			<div class="form-group row">
				<label class="col-sm-2 col-form-label text-right" for="price_title">Title</label>
				<div class="col-sm-4">
					@if(isset($package) && $package->price_detail)
						<input type="hidden" name="price_detail_id" value="{{ $package->price_detail->id }}">
					@endif
					<select name="price_title" id="" class="form-control">
						<option value="">Select</option>
						@foreach (config('price') as $id => $price)
						<option
							{{ $id == old('price_title', isset($package->price_detail) ? $package->price_detail->title : null) ? 'selected="selected"' : null  }}
							value="{{ $id }}">{{ $price }}</option>
						@endforeach
					</select>
				</div>
			</div>
			<div class="form-group row">
				<label class="col-sm-2 col-form-label text-right" for="price_value">Value (Price)</label>
				<div class="col-sm-4">
					<input class="form-control" placeholder="Value (Price)" name="price_value"
						value="{{ old('price_value', isset($package->price_detail) ? $package->price_detail->value : null) }}" type="text"
						id="price_value">
				</div>
				<div class="col-sm-4">
					USD
				</div>
			</div>
		</div> --}}

<div role="tabpanel" class="tab-pane" id="inclusion_exclusion">
	<div class="form-group row">
		<label class="col-sm-2 col-form-label text-right" for="include">Inclusion</label>
		<div class="col-sm-10">
			<textarea class="col-md-8 form-control" rows="8" placeholder="include" name="include"
				id="include">{{ old('include', isset($package) ? $package->include : null) }}</textarea>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-2 col-form-label text-right" for="exclude">Exclusion</label>
		<div class="col-sm-10">
			<textarea class="col-md-8 form-control" rows="8" placeholder="exclude" name="exclude"
				id="exclude">{{ old('exclude', isset($package) ? $package->exclude : null) }}</textarea>
		</div>
	</div>
</div>

<div role="tabpanel" class="tab-pane" id="highlight_">
	<div class="form-group row">
		<div class="col-sm-10">
			<textarea class="form-control" rows="" placeholder="highlight" name="highlight"
				id="highlight">{{ old('highlight', isset($package) ? $package->highlight : null) }}</textarea>
		</div>
	</div>
</div>

<div role="tabpanel" class="tab-pane" id="trip_details_">
	<div class="form-group row">
		<div class="col-sm-10">
			<textarea class="form-control" rows="" placeholder="Trip Details" name="trip_details"
				id="trip_details">{{ old('trip_details', isset($package) ? $package->trip_details : null) }}</textarea>
		</div>
	</div>
</div>

<div role="tabpanel" class="tab-pane" id="graph">
	@if (isset($package) && $package->graphs) @foreach ($package->graphs as $graph)
	<div class="form-group row">
		<div class="col-sm-4">
			<input name="graphs_edit[id][]" value="{{ $graph->id }}" type="hidden">
			<input class="form-control" placeholder="Point" name="graphs_edit[point][]" value="{{ $graph->point }}"
				type="text" id="">
		</div>
		<div class="col-sm-4">
			<input class="form-control" placeholder="Value" name="graphs_edit[value][]" value="{{ $graph->value }}"
				type="text" id="">
		</div>
		{{--
				<div class="col-sm-4">
					<button class="btn btn-danger graph_delete" data-id="{{ $graph->id }}"><span
			class="lnr lnr-trash"></span></button>
	</div> --}}
</div>
@endforeach @endif

<div id="graphs_wrap">
	<div class="form-group row last">
		<div class="col-sm-4">
			<input class="form-control" placeholder="Point" name="graphs[point][]" value="" type="text">
		</div>
		<div class="col-sm-4">
			<input class="form-control" placeholder="Value" name="graphs[value][]" value="" type="text">
		</div>
	</div>
</div>
<div class="form-group row">
	<div class="col-sm-3"><button type="button" class="btn btn-primary btn-sm btn-block" onclick="graph_add_another()">
			Add Another</button></div>
</div>

</div>
</div>
</div>







@section('script')
<script>
	$(function () {

		$('.fact_delete').on('click', function(e){
			e.preventDefault();
			ele = $(this);
			id = ele.data('id');
			url = "{{ route('packages.factdelete') }}";

			$.ajax(url, {
				data: {
					'_token': "{{ csrf_token() }}",
					'id':id
				},
				type: 'POST',
				success:function(response) {
					if(response.status = 'success'){
						ele.closest('.form-group row').remove();
					}
				}
			});

		});

		@if(isset($package))

		$( "#factsortable" ).sortable({
			update: function (event, ui) {
				var data = $(this).sortable('toArray');
				url = "{{ route('packages.factorder') }}";
				$.ajax(url, {
					data: {
						package_id:"{{ $package->id }}",
						data: data,
					},
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					type: 'POST',
				});
			}
		});
		@endif

	});

</script>
@endsection