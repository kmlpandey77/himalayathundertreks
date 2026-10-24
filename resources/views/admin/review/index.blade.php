@extends('admin.app')
@section('title')
Reviews
@endsection

@section('actionbtn')
<a href="{{ route('reviews.create') }}" class="button button-primary button-pill button-small"><i class="lnr lnr-plus-circle"></i> <span>Add New</span></a>
@endsection

@section('content')

<div class="card">
	<div class="card-body">
		<table class="table table-hover table-striped">
			<thead>
				<tr>
					<th>Image</th>
					<th>Name, Country</th>
					<th>Title</th>
					<th>Created At</th>
					<th>Status</th>
					<th></th>
				</tr>
			</thead>
			<tbody id="sortable">
				@foreach ($reviews as $review)
					<tr id="{{ $review->id }}">
						<td><img src="{{ $review->image_path }}" alt="{{ $review->title }}" width="80"></td>
						<td>{{ $review->name }}, {{ $review->country->name }}</td>
						<td>{{ $review->title }}</td>
						<td>{{ $review->created_at->format('M d, Y') }}</td>
						<td>
							@if($review->status == 0)
								<form action="{{ route('review.approve',$review->id) }}" method="post">
									{{ csrf_field() }}
									<button type="submit" class="button button-secondary button-small button-square button-rounded"><i class="lnr lnr-checkmark-circle"></i></button>
								</form>

								<form onsubmit="return confirm('Are you sure?')" action="{{ route('reviews.destroy', $review->id) }}" method="post">
									{{ csrf_field() }}
									<button type="submit" class="button button-danger button-small button-square button-rounded"><i class="lnr lnr-cross-circle"></i></button>
								</form>
							@elseif($review->status == 1)
								<p class="text-success"><i class="lnr lnr-checkmark-circle"></i> Approved </p>
							@else
								<p class="text-danger"><i class="lnr lnr-cross-circle"></i> Declined </p>
							@endif
						</td>
						<td class="text-right">
							<div class="ml-auto">
								<form onsubmit="return confirm('Are you sure?')" action="{{ route('reviews.destroy', $review->id) }}" method="post">
									{{ method_field('DELETE') }} {{ csrf_field() }}
									<a class="button button-secondary button-small button-square button-rounded" href="{{ route('reviews.edit', $review->id) }}"><i class="lnr lnr-pencil"></i></a>
									<button type="submit" class="button button-danger button-small button-square button-rounded"><i class="lnr lnr-trash"></i></button>
								</form>
							</div>
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>

		<hr>

		{!! $reviews->links('vendor.pagination.bootstrap-4') !!}
	</div>
</div>
@endsection