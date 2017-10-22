@php
	$model = get_class($object);
	$collection = false;
	$fillable = null;
	if ($model == 'Illuminate\\Database\\Eloquent\\Collection') {
		$collection = true;
	} elseif(strpos($model, 'App\\') === 0) {
		$model = new $model;
		$fillable = $model->getFillable();
	} else {
		dump($model);
	}
@endphp
@if ($collection)
	@foreach ($object as $sub_object)
		@include('object_viewer', ['object' => $sub_object])
	@endforeach
@elseif ($fillable !== null)
	@foreach ($fillable as $field)
	<div class="row split">
		<div class="field">{{ ucwords(str_replace('_', ' ', $field)) }}</div>
		<textarea class="value">{{ $object->$field or '' }}</textarea>
	</div>
	@endforeach
@endif