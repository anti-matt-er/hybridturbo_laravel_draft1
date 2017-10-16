<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 16 Oct 2017 14:12:02 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Inventory
 * 
 * @property string $sku
 * @property string $parent_sku
 * @property int $weight
 * @property int $length
 * @property string $name
 * @property bool $sku_is_generated
 * 
 * @property \App\Models\Inventorycategory $inventorycategory
 * @property \App\Models\Inventoryexternal $inventoryexternal
 * @property \App\Models\Inventoryproperty $inventoryproperty
 * @property \Illuminate\Database\Eloquent\Collection $products
 * @property \Illuminate\Database\Eloquent\Collection $raws
 *
 * @package App\Models
 */
class Inventory extends Eloquent
{
	protected $table = 'inventory';
	protected $primaryKey = 'sku';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'weight' => 'int',
		'length' => 'int',
		'sku_is_generated' => 'bool'
	];

	protected $fillable = [
		'sku',
		'parent_sku',
		'weight',
		'length',
		'name',
		'sku_is_generated'
	];

	public function inventorycategory()
	{
		return $this->hasOne(\App\Models\Inventorycategory::class, 'sku');
	}

	public function inventoryexternal()
	{
		return $this->hasOne(\App\Models\Inventoryexternal::class, 'sku');
	}

	public function inventoryproperty()
	{
		return $this->hasOne(\App\Models\Inventoryproperty::class, 'sku');
	}

	public function products()
	{
		return $this->hasMany(\App\Models\Product::class, 'sku');
	}

	public function raws()
	{
		return $this->hasMany(\App\Models\Raw::class, 'sku');
	}
}
