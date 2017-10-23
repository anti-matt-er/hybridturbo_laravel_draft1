<div class="header @if (isset($first) && $first) {{ $order->status }} @endif">
	<div class="default-message">
		{{ ucfirst(class_basename($object)) }} {{ ucwords(str_replace('_', ' ', $object->getKeyName())) }}: #{{ $object->getKey() }}
		@if (isset($is_collection) && $is_collection)
			<a href="#" class="delete" data-bind="click: toggle">&minus;</a>
		@endif
	</div>
	<div class="removed-message">
		Item removed <a href="#" class="right" data-bind="click: toggle">Undo</a>
	</div>
</div>
<div class="nth-fixer"></div>