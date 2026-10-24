@extends('admin.app') 
@section('title')
Teams
@endsection

@section('actionbtn')
<a href="{{ route('teamcategories.index') }}" class="button button-secondary button-pill button-small"><i class="lnr lnr-list"></i> <span>Category</span></a>
<a href="{{ route('teams.create') }}" class="button button-primary button-pill button-small"><i class="lnr lnr-plus-circle"></i> <span>Add New</span></a>
@endsection
 
@section('content')

<div class="card">
	<div class="card-header">
		<form action="">
			<div class="form-group row mt-2 mb-2">
				<label class="col-sm-2 col-form-label col-form-label-sm">Filter</label>
				<div class="col-sm-3">
					<select onchange="this.form.submit()" name="category" id="category" class="custom-select form-control-sm">
						<option value="0">All Category</option>
						@foreach ($categories as $category)
						<option {{ request()->category == $category->id ? 'selected="selected"' : null  }} value="{{ $category->id }}">{{ $category->title }}</option>			
						@endforeach
					</select>
				</div>
			</div>
		</form>
	</div>

	<div class="card-body">
		<table class="table table-hover table-striped">
			<thead>
				<tr>
					<th>Image</th>
					<th>Name</th>
					<th>Position</th>
					<th>Category</th>
					<th>Created At</th>
					<th></th>
				</tr>
			</thead>
			<tbody id="sortable">
				@foreach ($teams as $team)			
					<tr id="{{ $team->id }}">
						<td><img src="{{ $team->thumb_image }}" alt="{{ $team->title }}" width="80"></td>
						<td>{{ $team->name }}</td>
						<td>{{ $team->position }}</td>
						<td>{{ $team->teamcategory ? $team->teamcategory->title : '-' }}</td>
						<td>{{ $team->created_at->format('M d, Y') }}</td>
						<td class="text-right">
							<div class="ml-auto">
								<form onsubmit="return confirm('Are you sure?')" action="{{ route('teams.destroy', $team->id) }}" method="post">
									{{ method_field('DELETE') }} {{ csrf_field() }}
									<a class="button button-secondary button-small button-square button-rounded" href="{{ route('teams.edit', $team->id) }}"><i class="lnr lnr-pencil"></i></a>
									<button type="submit" class="button button-danger button-small button-square button-rounded"><i class="lnr lnr-trash"></i></button>							
								</form>
							</div>
						</td>
					</tr>			
				@endforeach
			</tbody>
		</table>

		<hr>

		{!! $teams->links('vendor.pagination.bootstrap-4') !!}
	</div>
</div>
@endsection

@section('script')
<script>
	$( function() {
		$( "#sortable" ).sortable({
			update: function (event, ui) {
				var data = $(this).sortable('toArray');
				url = "{{ route('teams.order') }}";
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