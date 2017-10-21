@extends('global')

@section('title', "$order->reference $order->order_id")

@section('content')
<header>
@include('orders_header')
</header>
<main>
	<div class="single-page">
		<div class="order">
			@include('object_viewer', ['object' => $order])
		</div>
	</div>
</main>
@endsection