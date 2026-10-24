@extends('admin.app') 
@section('title')
Activities
@endsection

@section('actionbtn')
<a href="{{ route('activities.create') }}" class="button button-primary button-pill button-small"><i class="lnr lnr-plus-circle"></i> <span>Add New</span></a>
@endsection
 
@section('content')

<div class="card">
	<div class="card-body">
		<table class="table table-hover table-striped">
			<thead>
				<tr>
					<th>Destination</th>
					<th>Image</th>
					<th>Title</th>
					<th>Url</th>
					<th>Status</th>
					<th></th>
				</tr>
			</thead>
			<tbody id="sortable">
				@foreach ($activities as $activity)			
					<tr id="{{ $activity->id }}">
						<td>{{ $activity->destination->title }}</td>
						<td><img src="{{ $activity->image_path }}" alt="{{ $activity->title }}" width="80"></td>
						<td>{{ $activity->title }}</td>
						<td>{{ '/' . $activity->slug }}</td>
						<td>
							@if ($activity->status)
								<a class="text-success" data-toggle="tooltip" data-placement="bottom" title="Click to hide" href="{{ route('activities.showhide', $activity->id) }}">
								<i class="lnr lnr-checkmark-circle"></i>
								Active
							</a>
							@else
								<a class="text-danger" data-toggle="tooltip" data-placement="bottom" title="Click to show" href="{{ route('activities.showhide', $activity->id) }}">
									<i class="lnr lnr-cross-circle"></i>
									Draft
								</a>
							@endif
						</td>
						<td class="text-right">
							<div class="ml-auto">
								<form onsubmit="return confirm('Are you sure?')" action="{{ route('activities.destroy', $activity->id) }}" method="post">
									{{ method_field('DELETE') }} {{ csrf_field() }}
									<a class="button button-plain_gray button-small button-square button-rounded" href="{{ route('activityslides.index', $activity->id) }}" data-toggle="tooltip" data-placement="bottom" title="Click to manage image slider"><i class="lnr lnr-picture"></i></a>
									<a class="button button-secondary button-small button-square button-rounded" href="{{ route('activities.edit', $activity->id) }}"><i class="lnr lnr-pencil"></i></a>
									<button type="submit" class="button button-danger button-small button-square button-rounded"><i class="lnr lnr-trash"></i></button>							
								</form>
							</div>
						</td>
					</tr>			
				@endforeach
			</tbody>
		</table>

		<hr>

		{{-- {!! $activities->links('vendor.pagination.bootstrap-4') !!} --}}
	</div>
</div>
@endsection