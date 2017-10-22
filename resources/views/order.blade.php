@extends('global')

@section('title', "$order->reference $order->order_id")

@section('content')
<header>
@include('orders_header')
</header>
<main>
	<div class="single-page">
		<div class="order">
			<div class="order-header {{ $order->status }}">Order #{{ $order->reference }} ({{ $order->order_id }})</div>
			<div class="nth-fixer"></div>
			@include('object_viewer', ['object' => $order])
		</div>
	</div>
</main>
@endsection