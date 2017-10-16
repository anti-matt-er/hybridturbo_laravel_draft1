<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 16 Oct 2017 14:12:02 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class OrdersProduct
 * 
 * @property int $order_reference
 * @property int $order_item_id
 * 
 * @property \App\Models\Order $order
 * @property \App\Models\Product $product
 *
 * @package App\Models
 */
class OrdersProduct extends Eloquent
{
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'order_reference' => 'int',
		'order_item_id' => 'int'
	];

	protected $fillable = [
		'order_reference',
		'order_item_id'
	];

	public function order()
	{
		return $this->belongsTo(\App\Models\Order::class, 'order_reference');
	}

	public function product()
	{
		return $this->belongsTo(\App\Models\Product::class, 'order_item_id');
	}
}
