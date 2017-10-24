@extends('global')

@section('title', "$order->reference $order->order_id")

@section('content')
<header>
@include('orders_header')
</header>
<main>
	<div class="single-page">
		<form class="order">
			@include('object_viewer', ['object' => $order, 'first' => true])
			<button class="good">Save</button>
		</form>
	</div>
</main>
@endsection