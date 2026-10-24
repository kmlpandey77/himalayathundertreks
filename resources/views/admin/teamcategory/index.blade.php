@extends('admin.app') 
@section('title')
Team Categories
@endsection

@section('actionbtn')
<a href="{{ route('teams.index') }}" class="button button-secondary button-pill button-small"><i class="lnr lnr-arrow-left"></i> <span>Back</span></a>
<a href="{{ route('teamcategories.create') }}" class="button button-primary button-pill button-small"><i class="lnr lnr-plus-circle"></i> <span>Add New</span></a>
@endsection
 
@section('content')

<div class="card">
	<div class="card-body">
		<table class="table table-hover table-striped">
			<thead>
				<tr>
					<th>Title</th>
					<th>Created At</th>
					<th></th>
				</tr>
			</thead>
			<tbody id="sortable">
				@foreach ($teamcategories as $category)			
					<tr id="{{ $category->id }}">
						<td>{{ $category->title }}</td>
						<td>{{ $category->created_at->format('M d, Y') }}</td>
						<td class="text-right">
							<div class="ml-auto">
								<form onsubmit="return confirm('Are you sure?')" action="{{ route('teamcategories.destroy', $category->id) }}" method="post">
									{{ method_field('DELETE') }} {{ csrf_field() }}
									<a class="button button-secondary button-small button-square button-rounded" href="{{ route('teamcategories.edit', $category->id) }}"><i class="lnr lnr-pencil"></i></a>
									<button type="submit" class="button button-danger button-small button-square button-rounded"><i class="lnr lnr-trash"></i></button>							
								</form>
							</div>
						</td>
					</tr>			
				@endforeach
			</tbody>
		</table>

		<hr>

		{!! $teamcategories->links('vendor.pagination.bootstrap-4') !!}
	</div>
</div>
@endsection

@section('script')
<script>
	$( function() {
		$( "#sortable" ).sortable({
			update: function (event, ui) {
				var data = $(this).sortable('toArray');
				url = "{{ route('teamcategories.order') }}";
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