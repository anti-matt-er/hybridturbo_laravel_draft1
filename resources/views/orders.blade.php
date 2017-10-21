@extends('global')

@section('title', $title)

@section('content')
<header>
	<form action="/orders/search" method="GET" role="search"><input type="search" placeholder="Search..." name="q"><input type="submit" value="&#9658;"></form><!--
	--><nav class="dropdown">
		<ul>
			<li>
				Key
				<ul>
					<li>Foo</li>
					<li>Bar</li>
					<li>Looooooooooong cat is long</li>
				</ul>
			</li>
		</ul>
	</nav>
	<nav class="dropdown right">
		<ul>
			<li>
				Action
				<ul>
					<li>Foo</li>
					<li>Bar</li>
					<li>Looooooooooong cat is long</li>
				</ul>
			</li>
		</ul>
	</nav>
	<button class="process right">Process</button>
</header>
<main>
	<table class="full-scrollable sortable">
		<thead>
			<tr>
				<th><input type="checkbox" id="master_checkbox" /><label for="master_checkbox"></label></th>
				<th>Status</th>
				<th>Reference</th>
				<th>Time</th>
				<th>Source</th>
				<th>Customer</th>
				<th>Shipping</th>
				<th>Consignment</th>
				<th>Dimensions</th>
				<th>Items</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($orders as $order)
				<tr>
					<th class="{{ $order->status or 'Generated'}}">
						<input type="checkbox" id="{{ $order->reference }}" />
						<label for="{{ $order->reference }}"></label>
					</th>
					<td>
						{{ $order->status or 'Generated'}}
					</td>
					<td>
						<strong>{{ $order->reference }}</strong><br/>
						{{ $order->order_id }}<br/>
						<nav class="dropdown">
							<ul>
								<li>
									Action
									<ul>
										<li>Foo</li>
										<li>Bar</li>
										<li>Looooooooooong cat is long</li>
									</ul>
								</li>
							</ul>
						</nav>
					</td>
					<td sorttable_customkey="{{ $order->ordertime->time_placed->timestamp }}">
						<details>
							<summary>
									{{ $order->ordertime->time_placed->format('d/m/y H:i') }}
							</summary>
							<div>
							@foreach (Schema::getColumnListing('ordertime') as $i => $timeColumn)
									@if ($timeColumn != 'order_reference' && !is_null($order->ordertime->$timeColumn))
											<strong>{{ ucwords(str_replace('_', ' ', $timeColumn)) }}:</strong><br/>
											{{ $order->ordertime->$timeColumn->format('d/m/y H:i') }}<br/>
									@endif
							@endforeach
							</div>
						</details>
					</td>
					<td>
						{{ $order->source }} - {{ $order->account }}
					</td>
					<td>
						{{ $order->customer->first_name }} {{ $order->customer->last_name }}<br/>
					</td>
					<td>
						{{ $order->address->first_name }} {{ $order->address->last_name }}<br/>
						<br/>
						<strong>{{ $order->address->postal_code }}</strong> ({{ $order->address->country_code}})
					</td>
					<td>
						{{ $order->service }}
						<strong>{{ $order->courier_code }}</strong> &times; {{ $order->parcel_count }}
					</td>
					<td sorttable_customkey="{{ $order->weight * 1000 + $order->length }}">
						Weight: {{ number_format($order->weight / 1000, 3) }}kg<br/>
						Length: {{ number_format($order->length / 100, 2) }}m
					</td>
					<td sorttable_customkey="{{ $order->total_price }}">
						@foreach ($order->products as $i => $product)
							{{ $product->quantity }} &times;
							<strong>{{ $product->sku }}</strong>
							(<a href="{{ $product->image_url }}"><strong>{{ $product->id }}</strong></a>)
							{{ $product->name }}
							@if ($i != (count($order->products) -1))
								<hr/>
							@endif
						@endforeach
						<p class="right"><strong>Total:</strong> &pound;{{ number_format($order->total_price, 2) }}</p>
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>
</main>
<footer>
	<span>Showing {{ count($orders) }} orders</span>
	<span class="right">Last refreshed <strong>{{ date('Y-m-d H:i') }}</strong></span>
</footer>
@endsection