@extends('admin.app') 
@section('title')
Newsletters
@endsection

@section('actionbtn')
<a href="{{ route('newsletters.create') }}" class="button button-primary button-pill button-small"><i class="lnr lnr-plus-circle"></i> <span>Add New</span></a>
@endsection
 
@section('content')

<div class="card">
	<div class="card-body">
		<table class="table table-hover table-striped">
			<thead>
				<tr>
					<th>Title</th>
					<th>Type</th>
					<th>Created At</th>
					<th></th>
				</tr>
			</thead>
			<tbody id="sortable">
				@foreach ($newsletters as $newsletter)			
					<tr id="{{ $newsletter->id }}">
						<td>{{ $newsletter->title }}</td>
						<td>{{ $newsletter->type }}</td>
						<td>{{ $newsletter->created_at->format('M d, Y') }}</td>
						<td class="float-right">
							<div class="float-left" style="margin-left: 10px;"> 
								<form action="{{ route('resend', $newsletter->id) }}" method="post">
									{{ csrf_field() }}
									<button type="submit" class="btn btn-secondary btn-sm" data-toggle="tooltip" data-placement="bottom" title="Click to resend"><i class="lnr lnr-redo"></i></button>
								</form>
							</div>
						</td>
						<td class="text-right">
							<div class="ml-auto">
								<form onsubmit="return confirm('Are you sure?')" action="{{ route('newsletters.destroy', $newsletter->id) }}" method="post">
									{{ method_field('DELETE') }} {{ csrf_field() }}
									<a class="button button-secondary button-small button-square button-rounded" href="{{ route('newsletters.edit', $newsletter->id) }}"><i class="lnr lnr-pencil"></i></a>
									<button type="submit" class="button button-danger button-small button-square button-rounded"><i class="lnr lnr-trash"></i></button>							
								</form>
							</div>
						</td>
					</tr>			
				@endforeach
			</tbody>
		</table>

		<hr>

		{!! $newsletters->links('vendor.pagination.bootstrap-4') !!}
	</div>
</div>
@endsection