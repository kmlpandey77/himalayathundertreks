<div class="card-header sticky-top text-right" style="top:67px; background: #F8F9FA;">
	<button type="submit" class="button button-primary button-rounded button-small" name="save_close" value="save_close">
		<i class="lnr lnr-inbox"></i> <span>Save & Close</span>
	</button>
	<button type="submit" class="button button-secondary button-rounded button-small" name="save" value="save">
		<i class="lnr lnr-inbox"></i> <span>Save</span>

	</button>
	<a href="{{ route('subscribers.index') }}" class="button button-plain_gray button-rounded button-small"><i class="lnr lnr-exit"></i> <span>Cancel</span></a>
</div>

<div class="card-body">
	<div class="row">
		<div class="col-sm-8">
			<div class="form-group row">
				<label class="col-sm-2 col-form-label text-right" for="name">Name</label>
				<div class="col-sm-10">
					<input class="form-control" placeholder="Name" name="name" value="{{ old('name', isset($subscriber) ? $subscriber->name : null) }}" type="text" id="name">
				</div>
			</div>

			<div class="form-group row">
				<label class="col-sm-2 col-form-label text-right" for="email">Email</label>
				<div class="col-sm-10">
					<input class="form-control" placeholder="Email" name="email" value="{{ old('email', isset($subscriber) ? $subscriber->email : null) }}" type="text" id="email">
				</div>
			</div>

			<div class="form-group row">
				<label class="col-sm-2 col-form-label text-right" for="phone">Phone</label>
				<div class="col-sm-10">
					<input class="form-control" placeholder="Phone" name="phone" value="{{ old('phone', isset($subscriber) ? $subscriber->phone : null) }}" type="text" id="phone">
				</div>
			</div>
		</div>

		<div class="col-sm-4">
			<div class="form-group row">
				<label class="col-sm-12 col-form-label" for="subscriber_group">Subscriber Group</label>
				<div class="col-sm-12">
					@foreach($subscriber_groups as $sub_group)
					<label class="">
						<input type="checkbox" name="subscriber_groups[]"  value="{{ $sub_group->id }}"
						{{ is_array(old('subscriber_groups', isset($subscriber) ? $subscriber->subscriber_groups()->allRelatedIds()->toArray():null)) && in_array($sub_group->id, old('subscriber_groups', isset($subscriber) ? $subscriber->subscriber_groups()->allRelatedIds()->toArray():null)) ? 'checked=checked': null }} >
						{{ $sub_group->title }}
					</label>
					<br>
					@endforeach
				</div>
			</div>
		</div>
	</div>
</div>