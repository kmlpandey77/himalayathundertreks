@extends('admin.app') 
@section('title')
Dates - {{ $trip->title }}
@endsection

@section('actionbtn')
<a href="{{ route('packages.index') }}" class="button button-secondary button-pill button-small"><i class="lnr lnr-arrow-left"></i> <span>Back</span></a>
<a href="{{ route('tripdates.create', $trip->id) }}" class="button button-primary button-pill button-small"><i class="lnr lnr-plus-circle"></i> <span>Add New</span></a>
@endsection
 
@section('content')

<div class="card">
	<div class="card-body">
		<table class="table table-hover table-striped">
			<thead>
				<tr>
					<th>Package</th>
					<th>Start</th>
					<th>End</th>
					<th>Status</th>
					<th></th>
				</tr>
			</thead>
			<tbody id="sortable">
				@foreach ($dates as $date)			
					<tr id="{{ $date->id }}">
						<td>{{ $date->package->title }}</td>
						<td>{{ $date->start }}</td>
						<td>{{ $date->end }}</td>
						<td>{{ $date->status() }}</td>
						<td class="text-right">
							<div class="ml-auto">
								<form onsubmit="return confirm('Are you sure?')" action="{{ route('tripdates.destroy', $date->id) }}" method="post">
									{{ method_field('DELETE') }} {{ csrf_field() }}
									<a class="button button-secondary button-small button-square button-rounded" href="{{ route('tripdates.edit', $date->id) }}"><i class="lnr lnr-pencil"></i></a>
									<button type="submit" class="button button-danger button-small button-square button-rounded"><i class="lnr lnr-trash"></i></button>							
								</form>
							</div>
						</td>
					</tr>			
				@endforeach
			</tbody>
		</table>
	</div>
</div>
@endsection