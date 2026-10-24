@extends('admin.app') 
@section('title')
Settings
@endsection

@section('actionbtn')
<a href="{{ route('settings.create') }}" class="button button-primary button-pill button-small"><i class="lnr lnr-plus-circle"></i> <span>Add New</span></a>
@endsection
 
@section('content')

<div class="card">
	<div class="card-header">
		<div class="float-right">
			<button type="btn" class="btn btn-primary btn-sm"  data-toggle="modal" data-target="#googleModal"> Google </button>	
			<button type="btn" class="btn btn-primary btn-sm"  data-toggle="modal" data-target="#bingModal"> Bing </button>	
			<button type="btn" class="btn btn-primary btn-sm"  data-toggle="modal" data-target="#yandexModal"> Yandex </button>	
		</div>
	</div>

	<div class="card-body">
		<table class="table table-hover table-striped">
			<thead>
				<tr>
					<th>Title</th>
					<th>Value</th>
					<th>Status</th>
					<th></th>
				</tr>
			</thead>
			<tbody id="sortable">
				@foreach ($settings as $setting)
					@if($setting->title != 'google' && $setting->title != 'bing' && $setting->title != 'yandex')		
						<tr id="{{ $setting->id }}">
							<td>{{ $setting->title }}</td>
							<td>{{ Str::limit(strip_tags($setting->value), 75) }}</td>
							<td>
								@if ($setting->status)
									<a class="text-success" data-toggle="tooltip" data-placement="bottom" title="Click to hide" data-method="post" href="{{ route('settings.showhide', $setting->id) }}">
										<i class="lnr lnr-checkmark-circle"></i>
										Active
									</a>
								@else
									<a class="text-danger" data-toggle="tooltip" data-placement="bottom" title="Click to show" data-method="post" href="{{ route('settings.showhide', $setting->id) }}">
										<i class="lnr lnr-cross-circle"></i>
										Draft
									</a>
								@endif 
							</td>
							<td class="text-right">
								<div class="ml-auto">
									<form onsubmit="return confirm('Are you sure?')" action="{{ route('settings.destroy', $setting->id) }}" method="post">
										{{ method_field('DELETE') }} {{ csrf_field() }}
										<a class="button button-secondary button-small button-square button-rounded" href="{{ route('settings.edit', $setting->id) }}"><i class="lnr lnr-pencil"></i></a>
										<button type="submit" class="button button-danger button-small button-square button-rounded"><i class="lnr lnr-trash"></i></button>							
									</form>
								</div>
							</td>
						</tr>
					@endif	
				@endforeach
			</tbody>
		</table>

		<hr>

		{!! $settings->links('vendor.pagination.bootstrap-4') !!}
	</div>
</div>

<div class="modal fade" id="googleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  	<div class="modal-dialog" role="document">
	    <div class="modal-content">
	      	<div class="modal-header">
	        	<h5 class="modal-title" id="exampleModalLabel">Google Script</h5>
	        	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          		<span aria-hidden="true">&times;</span>
	        	</button>
	      	</div>
	      	@if(!isset($google_script))
	      		<form action="{{ route('setting.script') }}" method="post">
	      	@else
	        	<form action="{{ route('change.script', $google_script->id) }}" method="post">
	            {{ method_field('PUT') }}
	        @endif
	      		{{ csrf_field() }}

		      	<div class="modal-body">
		      		<input type="hidden" name="script_title" value="Google">
		        	<div class="form-group">
		        		<textarea name="script" id="script" class="form-control">{{ isset($google_script) ? $google_script->value : null }}</textarea>
		        	</div>

		        	<div class="form-group">
						<input type="checkbox" id="status" name="status"  value="1" {{ old('status', isset($google_script) ? $google_script->status : 1) == 1 ? 'checked=checked' : null  }}>
						<label for="status">Active</label>
					</div>
		      	</div>
		      	<div class="modal-footer">
		        	<button type="submit" class="btn btn-primary">Save</button>
		        	<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
		     	</div>
		     </form>
	    </div>
  	</div>
</div>

<div class="modal fade" id="bingModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  	<div class="modal-dialog" role="document">
	    <div class="modal-content">
	      	<div class="modal-header">
	        	<h5 class="modal-title" id="exampleModalLabel">Bing Script</h5>
	        	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          		<span aria-hidden="true">&times;</span>
	        	</button>
	      	</div>
	      	@if(!isset($bing_script))
	      		<form action="{{ route('setting.script') }}" method="post">
	      	@else
	        	<form action="{{ route('change.script', $bing_script->id) }}" method="post">
	            {{ method_field('PUT') }}
	        @endif
	      		{{ csrf_field() }}
	      		
		      	<div class="modal-body">
		      		<input type="hidden" name="script_title" value="Bing">
		        	<div class="form-group">
		        		<textarea name="script" id="script" class="form-control">{{ isset($bing_script) ? $bing_script->value : null }}</textarea>
		        	</div>

		        	<div class="form-group">
						<input type="checkbox" id="status" name="status"  value="1" {{ old('status', isset($bing_script) ? $bing_script->status : 1) == 1 ? 'checked=checked' : null  }}>
						<label for="status">Active</label>
					</div>
		      	</div>
		      	<div class="modal-footer">
		        	<button type="submit" class="btn btn-primary">Save</button>
		        	<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
		     	</div>
		     </form>
	    </div>
  	</div>
</div>

<div class="modal fade" id="yandexModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  	<div class="modal-dialog" role="document">
	    <div class="modal-content">
	      	<div class="modal-header">
	        	<h5 class="modal-title" id="exampleModalLabel">Yandex Script</h5>
	        	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          		<span aria-hidden="true">&times;</span>
	        	</button>
	      	</div>
	      	@if(!isset($yandex_script))
	      		<form action="{{ route('setting.script') }}" method="post">
	      	@else
	        	<form action="{{ route('change.script', $yandex_script->id) }}" method="post">
	            {{ method_field('PUT') }}
	        @endif
	      		{{ csrf_field() }}
	      		
		      	<div class="modal-body">
		      		<input type="hidden" name="script_title" value="Yandex">
		        	<div class="form-group">
		        		<textarea name="script" id="script" class="form-control">{{ isset($yandex_script) ? $yandex_script->value : null }}</textarea>
		        	</div>

		        	<div class="form-group">
						<input type="checkbox" id="status" name="status"  value="1" {{ old('status', isset($yandex_script) ? $yandex_script->status : 1) == 1 ? 'checked=checked' : null  }}>
						<label for="status">Active</label>
					</div>
		      	</div>
		      	<div class="modal-footer">
		        	<button type="submit" class="btn btn-primary">Save</button>
		        	<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
		     	</div>
		     </form>
	    </div>
  	</div>
</div>
@endsection