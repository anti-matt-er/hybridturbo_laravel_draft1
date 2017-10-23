@if (isset($object->iteratable) && $object->iteratable)
	@include('object_header')
	@foreach ($object->viewable as $field)
	<div class="row split">
		<div class="field">{{ ucwords(str_replace('_', ' ', $field)) }}</div>
		<span class="value viewable">{{ $object->$field or 'null' }}</span>
	</div>
	@endforeach
	@foreach ($object->editable as $field)
	<div class="row split">
		<div class="field">{{ ucwords(str_replace('_', ' ', $field)) }}</div>
		<textarea class="value">{{ $object->$field or '' }}</textarea>
	</div>
	@endforeach
	@foreach ($object->relationships as $field)
	<div class="row">
		<details>
			<summary class="field">{{ ucwords(str_replace('_', ' ', $field)) }}</summary>
			<div class="value">
				@include('object_viewer', ['object' => $object->$field, 'first' => false, 'is_collection' => class_basename($object->$field) == 'Collection'])
				@if (class_basename($object->$field) == 'Collection')
					<div class="new-collection" data-model="{{ str_singular($field) }}">
						<!-- ko foreach: items -->
						<div>
							<!-- ko foreach: {data: rows, as: 'row'} -->
							<div class="row split">
								<div class="field" data-bind="text: row"></div>
								<textarea class="value"></textarea>
							</div>
							<a href="#" data-bind="click: $parent.removeItem">Remove</a>
							<!-- /ko -->
						</div>
						<!-- /ko -->
						<button data-bind="click: addItem">Add new {{ str_singular($field) }}</button>
						<button data-bind="click: debug">Debug</button>
					</div>
				@endif
			</div>
		</details>
	</div>
	@endforeach
@else
	@include('object_fillable_viewer', ['object' => $object])
@endif