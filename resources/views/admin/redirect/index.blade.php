@extends('admin.app') 
@section('title')
Redirect
@endsection

@section('actionbtn')
<a href="{{ route('redirects.create') }}" class="button button-primary button-pill button-small"><i class="lnr lnr-plus-circle"></i> <span>Add New</span></a>
@endsection
 
@section('content')

<div class="card">
	<div class="card-body">
		<table class="table table-hover table-striped">
			<thead>
				<tr>
					<th>From</th>
					<th>To</th>
					<th>Created At</th>
					<th></th>
				</tr>
			</thead>
			<tbody id="sortable">
				@foreach ($redirects as $redirect)			
					<tr id="{{ $redirect->id }}">
						<td>{{ $redirect->from_url }}</td>
						<td>{{ $redirect->to_url }}</td>
						<td>{{ $redirect->created_at->format('M d, Y') }}</td>
						<td class="text-right">
							<div class="ml-auto">
								<form onsubmit="return confirm('Are you sure?')" action="{{ route('redirects.destroy', $redirect->id) }}" method="post">
									{{ method_field('DELETE') }} {{ csrf_field() }}
									<a class="button button-secondary button-small button-square button-rounded" href="{{ route('redirects.edit', $redirect->id) }}"><i class="lnr lnr-pencil"></i></a>
									<button type="submit" class="button button-danger button-small button-square button-rounded"><i class="lnr lnr-trash"></i></button>							
								</form>
							</div>
						</td>
					</tr>			
				@endforeach
			</tbody>
		</table>

		<hr>

		{!! $redirects->links('vendor.pagination.bootstrap-4') !!}
	</div>
</div>
@endsection