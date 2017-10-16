<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>title</title>
	<link rel="stylesheet" href="stylesheet.css" type="text/css">
	<link href="https://fonts.googleapis.com/css?family=Rubik:400,700" rel="stylesheet">
	<style>
		html {
		  -webkit-box-sizing: border-box;
		  -moz-box-sizing: border-box;
		  box-sizing: border-box;
		}

		*, *:before, *:after {
		  -webkit-box-sizing: inherit;
		  -moz-box-sizing: inherit;
		  box-sizing: inherit;
		}

		html, body {
			width: 100%;
			height: 100%;
			margin: 0;
			padding: 0;
		}

		body {
			font-family: 'Rubik', sans-serif;
			font-size: 13px;
			color: #263238;
			text-rendering: optimizeSpeed;
			display: flex;
			height: 100%;
			flex-flow: column;
		}

		header, footer, main {
			display: block;
		}

		header, footer {
			flex: 0 0 auto;
		}

		header {
			background: #CFD8DC;
			height: 3em;
		}

		footer {
			background: #CFD8DC;
			box-shadow: 0px -5px 20px 0px rgba(0,0,0,0.5);
			height: 2em;
			text-align: right;
			padding: 0.5em;
			z-index: 5;
			position: relative;
		}

		main {
			flex: 1 1 auto;
			position: relative;
		}

		.full-scrollable
		{
		    border-collapse: collapse;
		    table-layout: fixed;
		    width: 100%;
		    overflow: auto;
		    position: absolute;
		    height: 100%;
		    display: flex;
		    flex-flow: column;
		}

		.full-scrollable tbody, .full-scrollable thead
		{
		    display: flex;
		    flex-flow: column;
		    width: 100%;
		    min-width: 100%;
		    max-width: 100%;
		}

		.full-scrollable thead {
			flex: 0 0 auto;
			position: relative;
		    overflow-y: scroll;
		    box-shadow: 0px 5px 20px 0px rgba(0,0,0,0.5);
		    z-index: 5;
		}

		.full-scrollable tbody 
		{
		   flex: 1 1 auto;
		   overflow-y: scroll;
		   height: 100%;
		}

		.full-scrollable tr
		{
			display: table;
			width: 100%;
			flex: 0 0 auto;
		}

		.full-scrollable td
		{
			padding: 0.5em;
			vertical-align: top;
		}

		.full-scrollable tbody tr:first-child td,
		.full-scrollable tbody tr:first-child th,
		.full-scrollable tbody tr:last-child td,
		.full-scrollable tbody tr:last-child th
		{
			position: relative;
			z-index: 10;
		}

		.full-scrollable tr:nth-child(odd) td
		{
			background: #F4F5FB;
			background-clip: padding-box;
		}

		.full-scrollable tr:nth-child(even) td
		{
			background: #E8EAF6;
		}

		.full-scrollable tbody tr:nth-child(odd) th
		{
			background: #CFCFCF;
		}

		.full-scrollable tbody tr:nth-child(even) th
		{
			background: #B0BEC5;
		}

		.full-scrollable th,
		.full-scrollable td
		{
			width: 9%;
			min-width: 9%;
		    max-width: 9%;
		    border-right: 1px solid #ccc;
		    font-weight: normal;
		}

		.full-scrollable tbody th
		{
			background: #bbb;
			color: #fff;
			border-right: none;
		}

		.full-scrollable thead th
		{
			background: #263238;
			color: #fff;
			border-bottom: 1px solid #222;
			border-right: 1px solid #666;
		}

		.full-scrollable tbody tr:last-child td,
		.full-scrollable tbody tr:last-child th
		{
			border-bottom: none;
		}

		.full-scrollable th:first-child,
		.full-scrollable td:first-child
		{
			width: 2%;
			min-width: 2%;
			max-width: 2%;
		}

		.full-scrollable th:nth-child(2),
		.full-scrollable td:nth-child(2)
		{
			width: 4%;
			min-width: 4%;
			max-width: 4%;
		}

		.full-scrollable th:last-child,
		.full-scrollable td:last-child
		{
			width: 31%;
			min-width: 31%;
			max-width: 31%;
		}



		input[type="search"] {
			display: inline-block;
			padding: 0;
			font-size: 2em;
			border-radius: 0;
			-webkit-appearance: none;
			background: #ECEFF1;
			background-image: linear-gradient(
				transparent,
				transparent 90%,
				#CFD8DC 90%
			);
			border: 0.2em solid #ECEFF1;
			border-width: 0.2em 0.75em;
			/*box-shadow: 0 0 0 0.5em #B0BEC5;*/
			height: 100%;
			width: 15%;
			transition: all 0.2s;
		}
		::-webkit-input-placeholder { /* Chrome */
		  	color: #B0BEC5;
		}
		:-ms-input-placeholder { /* IE 10+ */
		  	color: #B0BEC5;
		}
		::-moz-placeholder { /* Firefox 19+ */
		  	color: #B0BEC5;
		  	opacity: 1;
		}
		:-moz-placeholder { /* Firefox 4 - 18 */
		  	color: #B0BEC5;
		  	opacity: 1;
		}
		:focus::-webkit-input-placeholder { /* Chrome */
		  	color: #ECEFF1;
		}
		:focus:-ms-input-placeholder { /* IE 10+ */
		  	color: #ECEFF1;
		}
		:focus::-moz-placeholder { /* Firefox 19+ */
		  	color: #ECEFF1;
		  	opacity: 0;
		}
		:focus:-moz-placeholder { /* Firefox 4 - 18 */
		  	color: #ECEFF1;
		  	opacity: 0;
		}
		input[type="search"]:focus {
			outline: none;
			width: 35%;
			background-image: linear-gradient(
				transparent,
				transparent 90%,
				#B0BEC5 90%
			);
		}
		input[type="submit"], button {
			padding: 0;
			border-radius: 0;
			-webkit-appearance: none;
			border: none;
			padding: 0.2em 0.75em;
			background: #B0BEC5;
			color: #455A64;
		}
		header input[type="submit"], header button {
			display: inline-block;
			font-size: 2em;
			height: 100%;
		}
		input[type="submit"]:hover, button:hover {
			background: #90A4AE;
			color: #37474F;
		}
		h3 {
			margin: 0 0 0.5em;
		}
		hr {
		    margin: 0.3em;
		    border: none;
		    height: 1px;
		    width: 96%;
		    margin-left: 2%;
		    background: rgba(0, 0, 0, 0.25);
		}
		a, a:visited {
			color: #0091EA;
			text-decoration: none;
		}
		a:hover {
			color: #03A9F4;
			border-bottom: 2px dotted;
		}
	</style>
</head>
<body>
	<header>
		<input type="search" placeholder="Search..."><input type="submit" value="&#9658;">
	</header>
	<main>
		<table class="full-scrollable">
			<thead>
				<tr>
					<th><input type="checkbox" /></th>
					<th>Action</th>
					<th>Reference</th>
					<th>Time</th>
					<th>Customer</th>
					<th>Shipping</th>
					<th>Total Price</th>
					<th>Consignment</th>
					<th>Dimensions</th>
					<th>Items</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($orders as $order)
					<tr>
						<th><input type="checkbox" /></th>
						<td><button>Action</button></td>
						<td>
							<h3>{{ $order->reference }}</h3><br/>
							{{ $order->order_id }}<br/>
							({{ $order->source }} - {{ $order->account }})
						</td>
						<td>
							<strong>{{ $order->ordertime->time_placed }}</strong><br/>
							{{ $order->ordertime->time_retrieved }}
						</td>
						<td>
							{{ $order->customer->first_name }} {{ $order->customer->last_name }}
						</td>
						<td>
							{{ $order->address->first_name }} {{ $order->address->last_name }}<br/>
							<br/>
							<strong>{{ $order->address->postal_code }}</strong> ({{ $order->address->country_code}})
						</td>
						<td>
							&pound;{{ $order->total_price }}
						</td>
						<td>
							{{ $order->service }}<br/>
							<br/>
							<strong>{{ $order->courier_code }}</strong> &times; {{ $order->parcel_count }}
						</td>
						<td>
							Weight: {{ $order->weight }}g<br/>
							Length: {{ $order->length }}cm
						</td>
						<td>
							@foreach ($order->products as $i => $product)
								{{ $product->quantity }} &times;
								<strong>{{ $product->sku }}</strong>
								(<a href="{{ $product->image_url }}"><strong>{{ $product->id }}</strong></a>)
								{{ $product->name }}
								@if ($i != (count($order->products) -1))
									<hr/>
								@endif
							@endforeach
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	</main>
	<footer>
		Last refreshed <strong>{{ date('Y-m-d H:i') }}</strong>
	</footer>
</body>
</html>