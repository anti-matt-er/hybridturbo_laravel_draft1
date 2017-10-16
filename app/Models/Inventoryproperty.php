<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 16 Oct 2017 14:12:02 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Inventoryproperty
 * 
 * @property string $sku
 * @property string $name
 * @property string $value
 * @property string $source
 * @property string $account
 * 
 * @property \App\Models\Inventory $inventory
 *
 * @package App\Models
 */
class Inventoryproperty extends Eloquent
{
	public $incrementing = false;
	public $timestamps = false;

	protected $fillable = [
		'sku',
		'name',
		'value',
		'source',
		'account'
	];

	public function inventory()
	{
		return $this->belongsTo(\App\Models\Inventory::class, 'sku');
	}
}
