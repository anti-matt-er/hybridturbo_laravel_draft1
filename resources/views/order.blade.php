@extends('global')

@section('title', "$order->reference $order->order_id")

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/zepto/1.2.0/zepto.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/knockout/3.4.2/knockout-debug.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/knockout.mapping/2.4.1/knockout.mapping.min.js"></script>
<script src="/js/knockout.js" defer></script>
@endpush

@section('content')
<header>
@include('orders_header')
</header>
<main>
	<div class="single-page">
		<form action="/order/{{ $order->reference }}" method="POST" class="order">
			<input type="hidden" name="_method" value="PUT">
  		<input type="hidden" name="_token" value="{{ csrf_token() }}">
			@include('object_viewer', ['object' => $order, 'first' => true])
			<button class="good" type="submit">Save</button>
		</form>
	</div>
</main>
@endsection

@push('scripts')
	<script defer>
		objectViewer = {};
		@stack('objectViewerJavascript')
	</script>
@endpush
