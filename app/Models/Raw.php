<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 16 Oct 2017 14:12:02 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Raw
 * 
 * @property int $id
 * @property int $order_reference
 * @property string $sku
 * @property string $path
 * 
 * @property \App\Models\Order $order
 * @property \App\Models\Inventory $inventory
 *
 * @package App\Models
 */
class Raw extends Eloquent
{
	protected $table = 'raw';
	public $timestamps = false;

	protected $casts = [
		'order_reference' => 'int'
	];

	protected $fillable = [
		'order_reference',
		'sku',
		'path'
	];

	public function order()
	{
		return $this->belongsTo(\App\Models\Order::class, 'order_reference');
	}

	public function inventory()
	{
		return $this->belongsTo(\App\Models\Inventory::class, 'sku');
	}
}
