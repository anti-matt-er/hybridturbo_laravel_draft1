@extends('global')

@section('title', 'New Order')

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/zepto/1.2.0/zepto.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/knockout/3.4.2/knockout-debug.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/knockout.mapping/2.4.1/knockout.mapping.min.js"></script>
<script>
	objectViewer = {};
</script>
<script src="/js/knockout.js" defer></script>
@endpush

@section('content')
<main>
	<div class="single-page">
		<form action="/order" method="POST" class="order">
			<input type="hidden" name="_method" value="PUT">
  		<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<div class="header">New Order</div>
      <div class="nth-fixer"></div>
			<div>
	      <div class="row split editable">
	        <div class="field">Order ID</div>
	        <textarea name="order_id" class="value"></textarea>
	      </div>
				<div class="row split editable">
					<div class="field">Courier</div>
					<select name="courier" class="value" required>
						<option value="" disabled selected>Please select an option...</option>
						@foreach($couriers as $courier)
							<option value="{{ $courier->code }}">{{ $courier->code }} - {{ $courier->name }}</option>
							@if($courier->integrated)
								<option value="{{ $courier->code }}I">{{ $courier->code }}I - {{ $courier->name }} (integrated)</option>
							@endif
						@endforeach
					</select>
				</div>
				<div class="row split editable" required>
					<div class="field">Account</div>
					<textarea name="account" class="value">Elixir</textarea>
				</div>
				<div class="row split editable">
					<div class="field">Customer Email</div>
					<textarea name="customer.email" class="value"></textarea>
				</div>
				<div class="row split editable">
					<div class="field">Customer Telephone Number</div>
					<textarea name="customer.telephone" class="value"></textarea>
				</div>
				<div class="row split editable">
					<div class="field">Delivery Instructions</div>
					<textarea name="order_message" class="value"></textarea>
				</div>
			</div>
			<div class="row">
				<details open>
					<summary class="field">Address</summary>
					<div class="value">
						<div class="row split editable" required>
							<div class="field">First Name</div>
							<textarea name="address.first_name" class="value"></textarea>
						</div>
						<div class="row split editable" required>
							<div class="field">Last Name</div>
							<textarea name="address.first_name" class="value"></textarea>
						</div>
						<div class="row split editable" required>
							<div class="field">Line 1</div>
							<textarea name="address.line_1" class="value"></textarea>
						</div>
						<div class="row split editable" required>
							<div class="field">Line 2</div>
							<textarea name="address.line_2" class="value"></textarea>
						</div>
						<div class="row split editable" required>
							<div class="field">Line 3</div>
							<textarea name="address.line_3" class="value"></textarea>
						</div>
						<div class="row split editable" required>
							<div class="field">City</div>
							<textarea name="address.city" class="value"></textarea>
						</div>
						<div class="row split editable" required>
							<div class="field">Region</div>
							<textarea name="address.region" class="value"></textarea>
						</div>
						<div class="row split editable" required>
							<div class="field">Postal Code</div>
							<textarea name="address.postal_code" class="value"></textarea>
						</div>
						<div class="row split editable" required>
							<div class="field">Country Code</div>
							<textarea name="address.country_code" class="value">GB</textarea>
						</div>
					</div>
				</details>
			</div>
			<div class="row">
				<details open>
					<summary class="field">Products</summary>
					<div class="value">
						@include('object_new_collection', ['field' => 'products'])
					</div>
				</details>
			</div>
			<div>
				<div class="row split editable">
					<div class="field">Total Price</div>
					<textarea name="customer.total_price" class="value" data-format="style: 'currency'">0.00</textarea>
				</div>
				<div class="row split editable">
					<div class="field">Parcel Count</div>
					<textarea name="customer.parcel_count" class="value" data-format="style: 'integer'">1</textarea>
				</div>
				<div class="row split editable">
					<div class="field">Total Weight</div>
					<textarea name="customer.weight" class="value">0</textarea>
				</div>
				<div class="row split editable">
					<div class="field">Total Length</div>
					<textarea name="customer.length" class="value">0</textarea>
				</div>
			</div>
			<button class="good" type="submit">Submit &amp; Process</button>
		</form>
	</div>
</main>
@endsection
