<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;

Route::get('/orders', function () {
	$orders = App\Models\Order::whereNull('status')->orWhereNotIn('status', ['Dispatched', 'Void'])->get();
    return view('orders', [
    	'orders' => $orders,
    	'title' => 'Orders'
    ]);
});

Route::get('/order/{reference}', function ($reference) {
	$order = App\Models\Order::find($reference);
	return view('order', [
		'order' => $order
	]);
});

Route::put('/order', function (Request $request) {
	$order = new App\Models\Order();
	$data = $request->data;
	$newData = [];
	dump($data);
	foreach ($data as $column => &$datum) {
		$resource = $order;
		$field = $column;
		if (strpos($column, '.') !== false) {
			$columns = explode('.', $column);
			$resource = $columns[0];
			$resource = "App\\Models\\$resource";
			$resource = new $resource;
			$field = $columns[1];
		}
		$type = get_field_type($resource, $field);
		switch ($type) {
			case 'integer':
				$datum = preg_replace('/[^\d]/', '', $datum);
				break;
			case 'decimal':
			case 'float':
				$datum = preg_replace('/[^\d\.]/', '', $datum);
				break;
			default:
				//do nothing
		}
		array_set($newData, $column, $datum);
	}
	$newData['source'] = 'Manual';
	$newData['status'] = 'Printed';
	$courier = $newData['courier_code'];
	if (strrpos($courier, 'I') === (strlen($courier) -1)) {
		$courier = substr($courier, 0, -1);
		$newData['courier_code'] = $courier;
		$integrated = true; //not sure what to do with this yet
	}
	$courier = App\Models\Courier::find($courier);
	$services = explode(',', $courier->available_services);
	$newData['service'] = $services[count($services)-1];
	if (!$newData['address']['last_name']) {
		$newData['address']['last_name'] = $newData['address']['first_name'];
	}
	dump($newData);
	DB::transaction(function () use ($order, $newData) {
		$orderData = $newData;
		foreach($orderData as $field => &$value) {
			if (is_array($value)) {
				unset($value);
			}
		}
		$address = App\Models\Address::create($newData['address']);
		$orderData['address_id'] = $address->id;
		$customer = $newData['customer'];
		$customer['first_name'] = $address->first_name;
		$customer['last_name'] = $address->last_name;
		$customer['address_id'] = $address->id;
		$customer = App\Models\Customer::create($customer);
		$orderData['customer_id'] = $customer->id;
		$order->fill($orderData);
		if (array_key_exists('products', $newData)) {
			foreach($newData['products'] as $product) {
				$product = App\Models\Product::create($product);
				$order->attach($product);
			}
		}
		$order->save();
		$time = App\Models\Ordertime::create([
			'order_reference' => $order->reference,
			'time_placed' => now(),
			'time_retrieved' => now()
		]);
	});
	dd($order->toArray());
	return back();
});

Route::put('/{model}/{key}', function ($model, $key, Request $request) {
	$model = "App\\Models\\" . ucfirst($model);
	$resource = new $model;
	$resource = $resource->find($key);
	$newData = $request->data;
	DB::transaction(function () use ($resource, $newData) {
		$resource = update_resource($resource, $newData);
		$resource->save();
	});
	return back();
});

Route::get('new/order', function() {
	$order = new App\Models\Order();
	$couriers = App\Models\Courier::all();
	return view('new_order', [
		'order' => $order,
		'couriers' => $couriers
	]);
});

Route::get('/new/{object}', function($object) {
	$name = ucfirst($object);
	$object = "App\\Models\\" . $name;
	$object = new $object;
	$fillable = $object->getFillable();
	return view('new_object', [
		'name' => $name,
		'object' => $object,
		'fillable' => $fillable
	]);
});

Route::get('/orders/search', function() {
	//dd('/orders/search/'.Input::get('q'));
	return redirect('/orders/search/q/'.Input::get('q'));
});

Route::get('/orders/search/q/{q?}', function ($q = '') {
	$q = trim($q);

	// We need to search each collection, but also allow for quick order_id and reference selects

	// Start by making a blank collection, for when nothing is found
	$orders = collect();
	// Check if the query isn't blank
	if ($q) {
		// First try reference
		$order = App\Models\Order::find($q);
		// If found, add to a collection
		if (!is_null($order)) {
			$orders = collect([$order]);
		}
		// Otherwise, try order_id
		else {
			$orders = App\Models\Order::where('order_id', $q)->get(); // ->get() instead of ->first() so that it's a collection
		}
		// Now the common searches are out the way, we will build a collection of possible results
		if ($orders->isEmpty()) {
			$orders = $orders->merge(App\Models\Order::search($q)->get());
			$customers = App\Models\Customer::search($q)->get()->load('orders');
			foreach ($customers as $customer) {
				$orders = $orders->merge($customer->orders);
			}
			$addresses = App\Models\Address::search($q)->get()->load('orders', 'customers.orders');
			foreach ($addresses as $address) {
				$orders = $orders->merge($address->orders);
				foreach ($address->customers as $customer) {
					$orders = $orders->merge($customer->orders);
				}
			}

			// Now we have the results, weigh them
			$terms = explode(' ', $q);
			$idealCount = count($terms);
			$idealFound = false;
			$pointsTable = [];
			foreach ($orders as $originalKey => $order) {
				$points = 0;
				$flatOrder = array_dot($order->load(['customer.address', 'address'])->toArray());
				$termsFound = [];
				foreach ($terms as $term) {
					$termsFound[$term] = 0;
					foreach ($flatOrder as $field) {
						if (stripos($field, $term) !== false) {
							$points++;
							$termsFound[$term] = 1;
						}
					}
				}
				$termsFound = array_sum($termsFound);
				if ($termsFound === $idealCount) {
					$idealFound = true;
				}
				$pointsTable[] = [
					'termsFound' => $termsFound,
					'points' => $points,
					'originalKey' => $originalKey,
					'order' => $order
				];
			}
			// Sort on their points
			usort($pointsTable, function($a, $b) {
				if ($a['termsFound'] == $b['termsFound']) {
					if ($a['points'] == $b['points']) {
						return $a['originalKey'] <=> $b['originalKey'];
					}
					return $a['points'] <=> $b['points'];
				}
				return $a['termsFound'] <=> $b['termsFound'];
			});
			// Flatten into new collection
			$orders = collect();
			foreach ($pointsTable as $pointsOrder) {
				if ($idealFound == false || ($idealFound == true && $pointsOrder['termsFound'] == $idealCount)) {
					$orders->push($pointsOrder['order']);
				}
			}
		}
	}

	return view('orders', [
		'orders' => $orders,
		'title' => $q,
		'query' => $q
	]);
});
