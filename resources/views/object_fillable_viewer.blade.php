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
	@foreach ($object as $key => $sub_object)
		<div class="collection" data-bind="css: {removed : !visible() }">@include('object_viewer', ['object' => $sub_object, 'is_collection' => true])</div>
	@endforeach
@elseif ($fillable !== null)
	@include('object_header')
	@foreach ($fillable as $field)
	<div class="row split">
		<div class="field">{{ ucwords(str_replace('_', ' ', $field)) }}</div>
		<textarea class="value">{{ $object->$field or '' }}</textarea>
	</div>
	@endforeach
@endif