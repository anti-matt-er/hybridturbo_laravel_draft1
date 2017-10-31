@extends('global')

@section('title', "$order->reference $order->order_id")

@section('content')
<header>
@include('orders_header')
</header>
<main>
	<div class="single-page">
		<form action="/order/{{ $order->reference }}" method="POST" class="order">
			<script>
				var objectViewer = {};
			</script>
			<input type="hidden" name="_method" value="PUT">
  		<input type="hidden" name="_token" value="{{ csrf_token() }}">
			@include('object_viewer', ['object' => $order, 'first' => true])
			<button class="good" type="submit">Save</button>
		</form>
	</div>
</main>
@endsection
