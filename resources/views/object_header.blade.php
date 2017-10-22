<div class="header @if (isset($first) && $first) {{ $order->status }} @endif">
	<div class="default-message">
		{{ ucfirst(class_basename($object)) }} {{ ucwords(str_replace('_', ' ', $object->getKeyName())) }}: #{{ $object->getKey() }}
		@if (isset($is_collection) && $is_collection)
			<a href="#" class="delete" v-on:click="removed = !removed">&minus;</a>
		@endif
	</div>
	<div class="removed-message">
		Item removed <a href="#" class="right" v-on:click="removed = !removed">Undo</a>
	</div>
</div>
<div class="nth-fixer"></div>