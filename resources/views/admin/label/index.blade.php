@extends('admin.app') 
@section('title')
Labels
@endsection

@section('actionbtn')
<a href="{{ route('labels.create') }}" class="button button-primary button-pill button-small"><i class="lnr lnr-plus-circle"></i> <span>Add New</span></a>
@endsection
 
@section('content')

<div class="card">
	<div class="card-body">
		<table class="table table-hover table-striped">
			<thead>
				<tr>
					<th>Page</th>
					<th>Label Id</th>
					<th>Value</th>
					<th>Created At</th>
					<th></th>
				</tr>
			</thead>
			<tbody id="sortable">
				@foreach ($labels as $label)			
					<tr id="{{ $label->id }}">
						<td>{{ $label->page }}</td>
						<td>{{ $label->labelid }}</td>
						<td>{{ $label->value }}</td>
						<td>{{ $label->created_at->format('M d, Y') }}</td>
						<td class="text-right">
							<div class="ml-auto">
								<form onsubmit="return confirm('Are you sure?')" action="{{ route('labels.destroy', $label->id) }}" method="post">
									{{ method_field('DELETE') }} {{ csrf_field() }}
									<a class="button button-secondary button-small button-square button-rounded" href="{{ route('labels.edit', $label->id) }}"><i class="lnr lnr-pencil"></i></a>
									<button type="submit" class="button button-danger button-small button-square button-rounded"><i class="lnr lnr-trash"></i></button>							
								</form>
							</div>
						</td>
					</tr>			
				@endforeach
			</tbody>
		</table>

		<hr>

		{!! $labels->links('vendor.pagination.bootstrap-4') !!}
	</div>
</div>
@endsection