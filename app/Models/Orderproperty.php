<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 16 Oct 2017 14:12:02 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Orderproperty
 * 
 * @property int $order_reference
 * @property string $name
 * @property string $value
 * 
 * @property \App\Models\Order $order
 *
 * @package App\Models
 */
class Orderproperty extends Eloquent
{
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'order_reference' => 'int'
	];

	protected $fillable = [
		'order_reference',
		'name',
		'value'
	];

	public $iteratable = true;

	public $viewable = [];

	public $editable = [
		'name',
		'value'
	];

	public $relationships = [];

	public function order()
	{
		return $this->belongsTo(\App\Models\Order::class, 'order_reference');
	}
}
