<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 16 Oct 2017 14:12:02 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Product
 *
 * @property int $order_item_id
 * @property string $sku
 * @property string $id
 * @property string $image_url
 * @property string $name
 * @property float $price
 * @property float $shipping
 * @property int $quantity
 *
 * @property \App\Models\Inventory $inventory
 * @property \Illuminate\Database\Eloquent\Collection $orders
 *
 * @package App\Models
 */
class Product extends Eloquent
{
	use \Laravel\Scout\Searchable;

	protected $primaryKey = 'order_item_id';
	protected $hidden = ['pivot'];
	public $timestamps = false;

	protected $casts = [
		'price' => 'float',
		'shipping' => 'float',
		'quantity' => 'int'
	];

	protected $fillable = [
		'sku',
		'id',
		'image_url',
		'name',
		'price',
		'shipping',
		'quantity'
	];

	public $formats = [
		'price' => 'currency',
		'shipping' => 'currency'
	];

	public function inventory()
	{
		return $this->belongsTo(\App\Models\Inventory::class, 'sku');
	}

	public function orders()
	{
		return $this->belongsToMany(\App\Models\Order::class, 'orders_products', 'order_item_id', 'order_reference');
	}
}
