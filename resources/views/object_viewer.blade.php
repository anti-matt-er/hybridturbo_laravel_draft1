@if (isset($object->iteratable) && $object->iteratable)
	@foreach ($object->viewable as $field)
	<div class="row">
		<span class="field">{{ $field }}</span>
		<span class="value">{{ $object->$field or 'null' }}</span>
	</div>
	@endforeach
	@foreach ($object->editable as $field)
	<div class="row">
		<span class="field">{{ $field }}</span>
		<input class="value" type="text" value="{{ $object->$field or '' }}" />
	</div>
	@endforeach
	@foreach ($object->relationships as $field)
	<div class="row">
		<details>
			<summary>{{ $field }}</summary>
			<div>@include('object_viewer', ['object' => $object->$field])</div>
		</details>
	</div>
	@endforeach
@else
	@include('object_fillable_viewer', ['object' => $object])
@endif