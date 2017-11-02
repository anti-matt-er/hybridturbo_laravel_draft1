<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 16 Oct 2017 14:12:02 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Tracking
 *
 * @property int $order_reference
 * @property string $tracking_number
 *
 * @property \App\Models\Order $order
 *
 * @package App\Models
 */
class Tracking extends Eloquent
{
	protected $table = 'tracking';
	protected $primaryKey = 'tracking_number';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'order_reference' => 'int'
	];

	protected $fillable = [
		'tracking_number',
		'order_reference'
	];

	public $iteratable = true;

	public $viewable = [];

	public $editable = [
		'tracking_number'
	];
	
	public $relationships = [];

	public function order()
	{
		return $this->belongsTo(\App\Models\Order::class, 'order_reference');
	}
}
