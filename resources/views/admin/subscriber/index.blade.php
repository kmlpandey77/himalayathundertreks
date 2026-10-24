@extends('admin.app') 
@section('title')
Subscriber
@endsection

@section('actionbtn')
<a href="{{ route('subscribers.create') }}" class="button button-primary button-pill button-small"><i class="lnr lnr-plus-circle"></i> <span>Add New</span></a>
<a href="{{ route('subscriber-groups.index') }}" class="button button-secondary button-pill button-small"><span>Manage Subscriber Groups</span></a>
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
					<th>Name</th>
					<th>Email</th>
					<th>Created At</th>
					<th></th>
				</tr>
			</thead>
			<tbody id="sortable">
				@foreach ($subscribers as $subscriber)			
					<tr id="{{ $subscriber->id }}">
						<td>{{ $subscriber->name }}</td>
						<td>{{ $subscriber->email }}</td>
						<td>{{ $subscriber->created_at->format('M d, Y') }}</td>
						<td class="text-right">
							<div class="ml-auto">
								<form onsubmit="return confirm('Are you sure?')" action="{{ route('subscribers.destroy', [$subscriber->id] + $_GET) }}" method="post">
									{{ method_field('DELETE') }} {{ csrf_field() }}
									<a class="button button-secondary button-small button-square button-rounded" href="{{ route('subscribers.edit', [$subscriber->id] + $_GET) }}"><i class="lnr lnr-pencil"></i></a>
									<button type="submit" class="button button-danger button-small button-square button-rounded"><i class="lnr lnr-trash"></i></button>							
								</form>
							</div>
						</td>
					</tr>			
				@endforeach
			</tbody>
		</table>

		<hr>

		{!! $subscribers->appends($_GET)->links('vendor.pagination.bootstrap-4') !!}
	</div>
</div>
@endsection