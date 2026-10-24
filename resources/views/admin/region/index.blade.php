@extends('admin.app') 
@section('title')
Regions
@endsection

@section('actionbtn')
<a href="{{ route('regions.create') }}" class="button button-primary button-pill button-small"><i class="lnr lnr-plus-circle"></i> <span>Add New</span></a>
@endsection
 
@section('content')

<div class="card">
	<div class="card-body">
		<table class="table table-hover table-striped">
			<thead>
				<tr>
					<th>Image</th>
					<th>Destination</th>
					<th>Activity</th>
					<th>Title</th>
					<th>Url</th>
					<th>Status</th>
					<th></th>
				</tr>
			</thead>
			<tbody id="sortable">
				@foreach ($regions as $region)			
					<tr id="{{ $region->id }}">
						<td><img src="{{ $region->image_path }}" alt="{{ $region->title }}" width="80"></td>
						<td>{{ $region->activity->destination->title }}</td>
						<td>{{ $region->activity->title }}</td>
						<td>{{ $region->title }}</td>
						<td>{{ '/' . $region->slug }}</td>
						<td>
							@if ($region->status)
								<a class="text-success" data-toggle="tooltip" data-placement="bottom" title="Click to hide" data-method="post" href="{{ route('regions.showhide', $region->id) }}">
								<i class="lnr lnr-checkmark-circle"></i>
								Active
							</a>
							@else
								<a class="text-danger" data-toggle="tooltip" data-placement="bottom" title="Click to show" data-method="post" href="{{ route('regions.showhide', $region->id) }}">
									<i class="lnr lnr-cross-circle"></i>
									Draft
								</a>
							@endif
						</td>
						<td class="text-right">
							<div class="ml-auto">
								<form onsubmit="return confirm('Are you sure?')" action="{{ route('regions.destroy', $region->id) }}" method="post">
									{{ method_field('DELETE') }} {{ csrf_field() }}
									<a class="button button-plain_gray button-small button-square button-rounded" href="{{ route('regionslides.index', $region->id) }}" data-toggle="tooltip" data-placement="bottom" title="Click to manage image slider"><i class="lnr lnr-picture"></i></a>
									<a class="button button-secondary button-small button-square button-rounded" href="{{ route('regions.edit', $region->id) }}"><i class="lnr lnr-pencil"></i></a>
									<button type="submit" class="button button-danger button-small button-square button-rounded"><i class="lnr lnr-trash"></i></button>							
								</form>
							</div>
						</td>
					</tr>			
				@endforeach
			</tbody>
		</table>

		<hr>

		{!! $regions->links('vendor.pagination.bootstrap-4') !!}
	</div>
</div>
@endsection

@section('script')
<script>
	$( function() {
		$( "#sortable" ).sortable({
			update: function (event, ui) {
				var data = $(this).sortable('toArray');
				url = "{{ route('regions.order') }}";
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
@endsection