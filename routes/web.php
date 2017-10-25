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

function addRelationshipData($resource, $data) {
	if (isset($resource->iteratable) && $resource->iteratable) {
		foreach($resource->relationships as $relationship) {
			$relationshipData = $resource->$relationship;
			$data[$relationship] = addRelationshipData($relationshipData, $relationshipData->toArray());
		}
	}
	return $data;
}

Route::put('/{model}/{key}', function ($model, $key, Request $request) {
	$model = "App\\Models\\" . ucfirst($model);
	$resource = new $model;
	//dump(Schema::getColumnListing($resource->getTable()));
	$resource = $resource->find($key);
	$oldData = $resource->toArray();
	$oldData = addRelationshipData($resource, $oldData);
	$oldData = array_dot($oldData);
	$newData = $request->data;
	
	$changedData = [];
	foreach ($newData as $key => $value) {
		if (!array_key_exists($key, $oldData) || $oldData[$key] != $value) {
			$changedData[$key] = $value;
		}
	}
	dump($changedData);
	$expandedChangedData = [];
	foreach ($changedData as $key => $value) {
		array_set($expandedChangedData, $key, $value);
	}
	dump($expandedChangedData);
	$resource->update($expandedChangedData);
	// UPDATE DOESN'T WORK FOR RELATIONSHIPS
	dump($resource->toArray());
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