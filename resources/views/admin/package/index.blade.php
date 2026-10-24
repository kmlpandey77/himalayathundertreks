@extends('admin.app')

@section('title')
Packages
@endsection

@section('actionbtn')
<a href="{{ route('packages.create', $_GET) }}" class="button button-primary button-pill button-small"><i class="lnr lnr-plus-circle"></i> <span>Add New</span></a>
@endsection

@section('content')

<div class="card">
	<div class="card-header">
		<form>
			<div class="form-group row mt-2 mb-2">
				<label class="col-sm-1 col-form-label col-form-label-sm text-right">Filter</label>
				<div class="col-sm">
					<select class="custom-select form-control-sm" onchange="this.form.submit()" name="activity" id="activity">
						<option value="0">All Activity</option>
						@foreach ($activities as $activity)
						<option {{ request()->activity == $activity->id ? 'selected="selected"' : null  }} value="{{ $activity->id }}">{{ $activity->title }}</option>			
						@endforeach
					</select>
				</div>
				<div class="col-sm">
					<select onchange="this.form.submit()" name="region" id="region" class="custom-select form-control-sm">
						<option value="0">All Region</option>
						@foreach ($regions as $region)
						<option {{ request()->region == $region->id ? 'selected="selected"' : null  }} value="{{ $region->id }}">{{ $region->title }}</option>			
						@endforeach
					</select>
				</div>
				<div class="col-sm offset-sm-1">
					<input type="text" class="form-control form-control-sm" name="keyword" placeholder="Keyword" value="{{ request()->keyword }}">					
				</div>
				<div class="col-sm-1">
					<button type="submit" class="btn btn-primary btn-sm"> Search </button>				
				</div>
				@if($_GET)
				<div class="col-sm-1">
					<a class="btn btn-danger btn-sm" href="{{ route('packages.index') }}">Clear</a>
				</div>
				@endif
			</div>
		</form>
	</div>
	<div class="card-body">
		@if($packages->count())
		<table class="table table-hover table-striped">
			<thead>
				<tr>
					<th>Category</th>
					<th>Title</th>
					<th>Status</th>
					<th></th>
				</tr>
			</thead>
			<tbody id="sortable">
				@foreach ($packages as $package)
				<tr id="{{ $package->id }}">
					<td title="{{ $package->category() ? $package->category()->title : '-' }}">{{ Str::limit($package->category() ? $package->category()->title : '-', 20) }}</td>
					<td title="{{ $package->title }}">{{ Str::limit($package->title, 50) }} - {{ $package->days() }}</td>
					<td>
						@if ($package->status)
							<a class="text-success" data-toggle="tooltip" data-placement="bottom" title="Click to hide" data-method="post" href="{{ route('packages.showhide', $package->id) }}">
								<i class="lnr lnr-checkmark-circle"></i>
								Active
							</a>
						@else
							<a class="text-danger" data-toggle="tooltip" data-placement="bottom" title="Click to show" data-method="post" href="{{ route('packages.showhide', $package->id) }}">
								<i class="lnr lnr-cross-circle"></i>
								Draft
							</a>
						@endif 
					</td>
					<td class="text-right">
									
						{{-- <a class="btn btn-primary btn-sm" href="{{ route('packages.edit', [$package->id] + $_GET) }}"><i class="lnr lnr-pencil"></i></a>
						<div class="pull-right" style="margin-left: 10px;"> 
							<form onsubmit="return confirm('Are you sure?')" action="{{ route('packages.destroy', [$package->id] + $_GET) }}" method="post">
								{{ method_field('DELETE') }}
								{{ csrf_field() }}
								<button type="submit" class="btn btn-danger btn-sm"><i class="lnr lnr-trash"></i></button>
							</form>
						</div> --}}

						<form onsubmit="return confirm('Are you sure?')" action="{{ route('packages.destroy', [$package->id] + $_GET) }}" method="post">
							{{ method_field('DELETE') }} {{ csrf_field() }}
							<a class="button button-plain_gray button-small button-square button-rounded" href="{{ route('tripslides.index', [$package->id] + $_GET) }}" data-toggle="tooltip" data-placement="bottom" title="Click to manage image slider of this trip"><i class="lnr lnr-picture"></i></a>				
							<a class="button button-plain_gray button-small button-square button-rounded" href="{{ route('tripdates.index', [$package->id] + $_GET) }}" data-toggle="tooltip" data-placement="bottom" title="Click to manage departure dates of this trip"><i class="lnr lnr-calendar-full"></i></a>	
							<a class="button button-secondary button-small button-square button-rounded" href="{{ route('packages.edit', [$package->id] + $_GET) }}"><i class="lnr lnr-pencil"></i></a>
							<button type="submit" class="button button-danger button-small button-square button-rounded"><i class="lnr lnr-trash"></i></button>							
						</form>
					</td>
				</tr>		
				@endforeach
			</tbody>
		</table>

		<hr>

		{!! $packages->appends($_GET)->links('vendor.pagination.bootstrap-4') !!}
		@else
		<p>Record(s) not found!</p>
		@endif
	</div>
</div>
@endsection

@section('script')

@if (request()->activity || request()->region)
<script>
	$( function() {
		$( "#sortable" ).sortable({
			update: function (event, ui) {
				var data = $(this).sortable('toArray');
				url = "{{ route('packages.order') }}";
				$.ajax(url, {
					data: {
						'_token': "{{ csrf_token() }}",
						'data':data
					},
					type: 'POST',
				});
			}
		});
	} );
</script>
@endif
@endsection