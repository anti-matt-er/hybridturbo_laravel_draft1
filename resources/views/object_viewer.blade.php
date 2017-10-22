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
					<button>Add new {{ str_singular($field) }}</button>
				@endif
			</div>
		</details>
	</div>
	@endforeach
@else
	@include('object_fillable_viewer', ['object' => $object])
@endif