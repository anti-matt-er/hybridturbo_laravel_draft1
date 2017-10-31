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
<script>
	objectViewer.{{ $jsAccessor }} = {};
</script>
@if (isset($object->iteratable) && $object->iteratable)
	@include('object_header')
	@foreach ($object->viewable as $field)
	<div class="row split">
		<div class="field">{{ ucwords(str_replace('_', ' ', $field)) }}</div>
		<span class="value viewable">{{ $object->$field or 'null' }}</span>
	</div>
	@endforeach
	@foreach ($object->editable as $field)
	<script>
		objectViewer.{{ $jsAccessor }}.{{ $field }} = {!! json_encode($object->$field) !!}
	</script>
	<div class="row split editable exists">
		<div class="field">{{ ucwords(str_replace('_', ' ', $field)) }}</div>
		<textarea class="value" name="data[{{ $keyAccessor }}{{ $field }}]" data-bind="textInput: {{ $jsAccessor }}.{{ $field }}">{{ $object->$field or '' }}</textarea>
	</div>
	@endforeach
	@foreach ($object->relationships as $field)
	<div class="row">
		<details>
			<summary class="field">{{ ucwords(str_replace('_', ' ', $field)) }}</summary>
			<div class="value">
				@include('object_viewer', ['object' => $object->$field, 'first' => false, 'parentField' => $keyAccessor.$field, 'is_collection' => class_basename($object->$field) == 'Collection'])
				@if (class_basename($object->$field) == 'Collection')
					<div class="new-collection" data-model="{{ str_singular($field) }}">
						<!-- ko foreach: $data.items -->
						<div>
							<div class="header good">
								<span data-bind="text: 'New ' + $parent.model.underscoreToWords()"></span>
								<a href="#" class="delete" data-bind="click:  $parent.removeItem">&minus;</a>
							</div>
							<div class="nth-fix"></div>
							<!-- ko foreach: {data: rows, as: 'row'} -->
							<div class="row split editable">
								<div class="field" data-bind="text: row.underscoreToWords()"></div>
								<textarea class="value" data-bind="attr: {name: 'data[{{ $keyAccessor }}{{ $field }}.'+($parentContext.$index()+{{ count($object->$field) }})+'.'+row+']'}"></textarea>
							</div>
							<!-- /ko -->
						</div>
						<!-- /ko -->
						<button data-bind="click: addItem">Add new {{ str_singular($field) }}</button>
					</div>
				@endif
			</div>
		</details>
	</div>
	@endforeach
@else
	@include('object_fillable_viewer', ['object' => $object, 'parentField' => $parentField])
@endif
