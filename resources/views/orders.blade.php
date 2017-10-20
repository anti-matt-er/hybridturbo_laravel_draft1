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
			color: #37474F;
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
			background: #546E7A;
			color: #ECEFF1;
			height: 2.5em;
		}

		header * {
			vertical-align:top;
			transition: all 0.2s;
		}

		footer {
			background: #263238;
			color: #fff;
			box-shadow: 0px -5px 20px 0px rgba(0,0,0,0.5);
			height: 2em;
			padding: 0.5em;
			z-index: 5;
			position: relative;
		}

		main {
			flex: 1 1 auto;
			position: relative;
			overflow-y: hidden;
			overflow-x: auto;
			width: 100%;
		}

		.full-scrollable
		{
		    border-collapse: collapse;
		    table-layout: fixed;
		    position: absolute;
		    height: 100%;
		    display: flex;
		    flex-flow: column;
		}

		.full-scrollable tbody, .full-scrollable thead
		{
		    display: flex;
		    flex-flow: column;
				overflow-y: scroll;
				overflow-x: hidden;
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

		.full-scrollable tbody tr:first-child td:nth-child(4),
		.full-scrollable tbody tr:last-child td:nth-child(4)
		{
			z-index: 9;
		}

		.full-scrollable tr:nth-child(odd) td
		{
			background: #F4F5FB;
		}

		.full-scrollable tr:nth-child(even) td
		{
			background: #E8EAF6;
		}

		.full-scrollable tbody th
		{
			background: #B0BEC5;
			border-right: none;
		}

		.full-scrollable th,
		.full-scrollable td
		{
			width: 9%;
			min-width: 104px;
		    max-width: 9%;
		    border-right: 1px solid #ccc;
		    font-weight: normal;
		}

		.full-scrollable thead th
		{
			background: #263238;
			color: #fff;
			border-bottom: 1px solid #222;
			border-right: 1px solid #666;
			height: 3em;
		}

		.full-scrollable tbody tr:last-child td,
		.full-scrollable tbody tr:last-child th
		{
			border-bottom: none;
		}

		.full-scrollable th:first-child,
		.full-scrollable td:first-child
		{
			width: 22px;
			min-width: 22px;
			max-width: 22px;
		}

		.full-scrollable th:nth-child(2),
		.full-scrollable td:nth-child(2)
		{
			width: 6%;
			min-width: 72px;
			max-width: 6%;
		}

		.full-scrollable td:nth-child(2)
		{
			font-variant: small-caps;
			vertical-align: middle;
			text-align: center;
		}

		.full-scrollable th:last-child,
		.full-scrollable td:last-child
		{
			width: 30%;
			min-width: 160px;
			max-width: 30%;
		}

		.full-scrollable:not(.hack):not(.hack) td
		{
			padding: 0.5em;
			vertical-align: top;
			background-clip: padding-box;
		}


		input[type="search"] {
			display: inline-block;
			padding: 0;
			font-size: 1.7em;
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
			min-width: 10em;
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
		input[type="submit"], button, .dropdown ul li {
			padding: 0;
			border-radius: 0;
			-webkit-appearance: none;
			border: none;
			padding: 0.2em 0.75em;
			background: #B0BEC5;
			color: #37474F;
			box-shadow: inset 0 0 0 1px rgba(0, 0, 0, 0.2);
		}
		header input[type="submit"], header button, header .dropdown {
			position: relative;
			display: inline-block;
			font-size: 1.7em;
			top: -1px;
		}
		header .dropdown ul,
		header .dropdown ul > li {
			height: 100%;
		}
		header .dropdown ul > li {
			height: 100%;
			line-height: 120%;
		}
		.dropdown.right ul ul {
				left: auto;
				right: 0;
		}
		input[type="submit"]:hover, button:hover, .dropdown ul li:hover {
			background: #CFD8DC;
			color: #0277BD;
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
		.dropdown * {
		    transition: all 0.1s;
		}
		.dropdown ul {
		    padding: 0;
		    margin: 0;
		    display: inline-block;
		    font-size: inherit;
				cursor: default;
		}
		.dropdown li {
		    display: inline-block;
		    font-size: inherit;
		}
		.dropdown > ul > li:after {
    		content: ' \25bc';
		}
		.dropdown ul li {
				position: relative;
		}
		.dropdown ul ul {
				min-width: 100%;
		    display: none;
		    position: absolute;
		    top: 100%;
		    left: 0;
		    white-space: nowrap;
		    border: inherit;
		    border-top: none;
				z-index: 50;
		}
		.dropdown ul li:hover > ul {
		    display: inherit;
		}
		.dropdown ul ul li {
		    float: none;
		    display: block;
		    position: relative;
		    margin-top: -1px;
		}
		details div {
		  display: none;
		}
		details[open] div {
			display: block;
		}
		summary {
			display: block;
			cursor: default;
			outline: none;
			-webkit-touch-callout: none; /* iOS Safari */
			-webkit-user-select: none; /* Safari */
			 -khtml-user-select: none; /* Konqueror HTML */
				 -moz-user-select: none; /* Firefox */
					-ms-user-select: none; /* Internet Explorer/Edge */
							user-select: none; /* Non-prefixed version, currently
																		supported by Chrome and Opera */
		}
	  summary::-webkit-details-marker {
		  display: none;
		}
		summary::before {
		  content: '\25BA';
		  padding-right: 0.1em;
		}
		details[open] > summary::before {
		  content: '\25BC';
		}
		.right {
			float: right;
		}
		.process {
			background: #4CAF50;
			color: #004D40;
		}
		.process:hover {
			background: #00E676;
		}
		.headerText {
			font-size: 1.7em;
			line-height: 150%;
			padding: 0 1em;
		}

		input[type="submit"]:not(.hack):not(.hack), button:not(.hack):not(.hack), .dropdown ul li:not(.hack):not(.hack) {
			background-image: linear-gradient(
				rgba(255, 255, 255, 0.5),
				transparent 60%,
				rgba(0, 0, 0, 0.05) 70%,
               	transparent
			);
		}

		table tbody tr th.Printed:not(.hack):not(.hack) {
				background: #F44336;
		}
		table tbody tr th.Scanned:not(.hack):not(.hack) {
				background: #4CAF50;
		}
		table tbody tr th.Dispatched:not(.hack):not(.hack) {
				background: #00BCD4;
		}
		table tbody tr th.Void:not(.hack):not(.hack) {
				background: #880E4F;
		}
		table tbody tr th.Hold:not(.hack):not(.hack) {
				background: #FFC107;
		}

		@media all and (-ms-high-contrast: none), (-ms-high-contrast: active) {
		   .full-scrollable {
				 	width: 100%;
			 }
		}
		@supports (-ms-accelerator:true) {
				.full-scrollable {
					 width: 100%;
				}
		}
			</style>
</head>
<body>
	<header>
		<input type="search" placeholder="Search..."><input type="submit" value="&#9658;"><!--
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
		<table class="full-scrollable">
			<thead>
				<tr>
					<th><input type="checkbox" /></th>
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
						<th class="{{ $order->status or 'Generated'}}"><input type="checkbox"/></th>
						<td>{{ $order->status or 'Generated'}}</td>
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
						<td>
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
</body>
</html>
