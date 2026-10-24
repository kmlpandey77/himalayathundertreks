@extends('admin.app') 
@section('title')
Subscriber Groups
@endsection

@section('actionbtn')
<a href="{{ route('subscribers.index') }}" class="button button-secondary button-pill button-small"><i class="lnr lnr-arrow-left"></i> <span>Back</span></a>
<a href="{{ route('subscriber-groups.create') }}" class="button button-primary button-pill button-small"><i class="lnr lnr-plus-circle"></i> <span>Add New</span></a>
@endsection
 
@section('content')

<div class="card">
	<div class="card-header">
		<form>
			<div class="form-group row mt-2 mb-2">
				<div class="col-sm-3">
					<input type="text" class="form-control form-control-sm" name="keyword" placeholder="Keyword" value="{{ request()->keyword }}">					
				</div>
			</div>
		</form>
	</div>

	<div class="card-body">
		<table class="table table-hover table-striped">
			<thead>
				<tr>
					<th>Title</th>
					<th>Created At</th>
				</tr>
			</thead>
			<tbody id="sortable">
				@foreach ($subscriber_groups as $sub_group)			
					<tr id="{{ $sub_group->id }}">
						<td>{{ $sub_group->title }}</td>
						<td>{{ $sub_group->created_at->format('M d, Y') }}</td>
						<td class="text-right">
							<div class="ml-auto">
								<form onsubmit="return confirm('Are you sure?')" action="{{ route('subscriber-groups.destroy', $sub_group->id) }}" method="post">
									{{ method_field('DELETE') }} {{ csrf_field() }}
									<a class="button button-secondary button-small button-square button-rounded" href="{{ route('subscriber-groups.edit', $sub_group->id) }}"><i class="lnr lnr-pencil"></i></a>
									<button type="submit" class="button button-danger button-small button-square button-rounded"><i class="lnr lnr-trash"></i></button>							
								</form>
							</div>
						</td>
					</tr>			
				@endforeach
			</tbody>
		</table>

		<hr>

		{!! $subscriber_groups->links('vendor.pagination.bootstrap-4') !!}
	</div>
</div>
@endsection