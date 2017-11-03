@php
	$keyAccessor = '';
	if (isset($parentField)) {
		$keyAccessor = $parentField.'.';
	} else {
		$parentField = '';
	}
	$m = get_class($object);
	$m = new $m;
	$m = (array) $m;
	$primaryKey = spl_object_hash($object);
	if (array_key_exists("\x00*\x00primaryKey", $m)) {
		$primaryKey = $object->{$m["\x00*\x00primaryKey"]};
	}
	$jsAccessor = class_basename($object).'_'.$primaryKey;
@endphp
@push('objectViewerJavascript')
	objectViewer.{{ $jsAccessor }} = {};
@endpush
@if (isset($object->iteratable) && $object->iteratable)
	@include('object_header')
	@foreach ($object->viewable as $field)
	<div class="row split">
		<div class="field">{{ ucwords(str_replace('_', ' ', $field)) }}</div>
		<span class="value viewable">{{ $object->$field or 'null' }}</span>
	</div>
	@endforeach
	@foreach ($object->editable as $field)
	@push('objectViewerJavascript')
		objectViewer.{{ $jsAccessor }}.{{ $field }} = {!! json_encode($object->$field) !!}
	@endpush
	<div class="row split editable exists">
		<div class="field">{{ ucwords(str_replace('_', ' ', $field)) }}</div>
		<textarea class="value" name="data[{{ $keyAccessor }}{{ $field }}]" data-bind="value: objectViewerModel.{{ $jsAccessor }}.{{ $field }}" {!! knockout_formatter($object, $field) !!}>{{ $object->$field or '' }}</textarea>
	</div>
	@endforeach
	@foreach ($object->relationships as $field)
	<div class="row">
		<details>
			<summary class="field">{{ ucwords(str_replace('_', ' ', $field)) }}</summary>
			<div class="value">
				@include('object_viewer', ['object' => $object->$field, 'first' => false, 'parentField' => $keyAccessor.$field, 'is_collection' => class_basename($object->$field) == 'Collection'])
				@if (class_basename($object->$field) == 'Collection')
					@include('object_new_collection', ['object' => $object, 'field' => $field])
				@endif
			</div>
		</details>
	</div>
	@endforeach
@else
	@include('object_fillable_viewer', ['object' => $object, 'parentField' => $parentField])
@endif
