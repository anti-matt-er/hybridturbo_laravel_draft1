<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 16 Oct 2017 14:12:02 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Inventoryexternal
 * 
 * @property string $sku
 * @property float $price
 * @property string $id
 * @property int $sales
 * @property string $source
 * @property string $account
 * 
 * @property \App\Models\Inventory $inventory
 *
 * @package App\Models
 */
class Inventoryexternal extends Eloquent
{
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'price' => 'float',
		'sales' => 'int'
	];

	protected $fillable = [
		'sku',
		'price',
		'id',
		'sales',
		'source',
		'account'
	];

	public function inventory()
	{
		return $this->belongsTo(\App\Models\Inventory::class, 'sku');
	}
}
