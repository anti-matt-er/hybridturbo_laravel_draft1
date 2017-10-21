<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 16 Oct 2017 14:12:02 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Order
 * 
 * @property int $reference
 * @property string $order_id
 * @property string $source
 * @property string $account
 * @property float $total_price
 * @property string $service
 * @property string $status
 * @property int $parcel_count
 * @property int $weight
 * @property int $length
 * @property string $order_message
 * @property string $courier_code
 * @property int $customer_id
 * @property int $address_id
 * 
 * @property \App\Models\Courier $courier
 * @property \App\Models\Customer $customer
 * @property \App\Models\Address $address
 * @property \App\Models\Orderproperty $orderproperty
 * @property \Illuminate\Database\Eloquent\Collection $products
 * @property \App\Models\Ordertime $ordertime
 * @property \Illuminate\Database\Eloquent\Collection $raws
 * @property \Illuminate\Database\Eloquent\Collection $trackings
 *
 * @package App\Models
 */
class Order extends Eloquent
{
	use \Laravel\Scout\Searchable;

	protected $primaryKey = 'reference';
	public $timestamps = false;

	protected $casts = [
		'total_price' => 'float',
		'parcel_count' => 'int',
		'weight' => 'int',
		'length' => 'int',
		'customer_id' => 'int',
		'address_id' => 'int'
	];

	protected $fillable = [
		'order_id',
		'source',
		'account',
		'total_price',
		'service',
		'status',
		'parcel_count',
		'weight',
		'length',
		'order_message',
		'courier_code',
		'customer_id',
		'address_id'
	];

	public function courier()
	{
		return $this->belongsTo(\App\Models\Courier::class, 'courier_code');
	}

	public function customer()
	{
		return $this->belongsTo(\App\Models\Customer::class);
	}

	public function address()
	{
		return $this->belongsTo(\App\Models\Address::class);
	}

	public function orderproperty()
	{
		return $this->hasOne(\App\Models\Orderproperty::class, 'order_reference');
	}

	public function products()
	{
		return $this->belongsToMany(\App\Models\Product::class, 'orders_products', 'order_reference', 'order_item_id');
	}

	public function ordertime()
	{
		return $this->hasOne(\App\Models\Ordertime::class, 'order_reference');
	}

	public function raws()
	{
		return $this->hasMany(\App\Models\Raw::class, 'order_reference');
	}

	public function trackings()
	{
		return $this->hasMany(\App\Models\Tracking::class, 'order_reference');
	}
}
