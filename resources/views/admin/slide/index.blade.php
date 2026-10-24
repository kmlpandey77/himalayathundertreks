@extends('admin.app')
@section('title')
Slides
@endsection

@section('actionbtn')
<a href="{{ route('slides.create') }}" class="button button-primary button-pill button-small"><i class="lnr lnr-plus-circle"></i> <span>Add New</span></a>
@endsection

@section('content')

<div class="card">
	<div class="card-body">
		<table class="table table-hover table-striped">
			<thead>
				<tr>
					<th>Image</th>
					<th>Title</th>
					<th>Status</th>
					<th></th>
				</tr>
			</thead>
			<tbody id="sortable">
				@foreach ($slides as $slide)
					<tr id="{{ $slide->id }}">
						<td><img src="{{ $slide->thumb_image }}" alt="{{ $slide->title }}" width="80"></td>
						<td>{{ $slide->title }}</td>
						<td>
							@if ($slide->status)
								<a class="text-success" data-toggle="tooltip" data-placement="bottom" title="Click to hide" data-method="post" href="{{ route('slides.showhide', $slide->id) }}">
								<i class="lnr lnr-checkmark-circle"></i>
								Active
							</a>
							@else
								<a class="text-danger" data-toggle="tooltip" data-placement="bottom" title="Click to show" data-method="post" href="{{ route('slides.showhide', $slide->id) }}">
									<i class="lnr lnr-cross-circle"></i>
									Draft
								</a>
							@endif
						</td>
						<td class="text-right">
							<div class="ml-auto">
								<form onsubmit="return confirm('Are you sure?')" action="{{ route('slides.destroy', $slide->id) }}" method="post">
									{{ method_field('DELETE') }} {{ csrf_field() }}
									<a class="button button-secondary button-small button-square button-rounded" href="{{ route('slides.edit', $slide->id) }}"><i class="lnr lnr-pencil"></i></a>
									<button type="submit" class="button button-danger button-small button-square button-rounded"><i class="lnr lnr-trash"></i></button>
								</form>
							</div>
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>

		<hr>

		{!! $slides->links('vendor.pagination.bootstrap-4') !!}
	</div>
</div>
@endsection

@section('script')
<script>
	$( function() {
		$( "#sortable" ).sortable({
			update: function (event, ui) {
				var data = $(this).sortable('toArray');
				url = "{{ route('slides.order') }}";
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