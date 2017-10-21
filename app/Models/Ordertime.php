<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 16 Oct 2017 14:12:02 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Ordertime
 * 
 * @property int $order_reference
 * @property \Carbon\Carbon $time_placed
 * @property \Carbon\Carbon $time_retrieved
 * @property \Carbon\Carbon $time_dispatched
 * @property \Carbon\Carbon $time_last_status
 * @property \Carbon\Carbon $time_delivered
 * @property \Carbon\Carbon $time_expected
 * 
 * @property \App\Models\Order $order
 *
 * @package App\Models
 */
class Ordertime extends Eloquent
{
	protected $table = 'ordertime';
	protected $primaryKey = 'order_reference';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'order_reference' => 'int'
	];

	protected $dates = [
		'time_placed',
		'time_retrieved',
		'time_dispatched',
		'time_last_status',
		'time_delivered',
		'time_expected'
	];

	protected $fillable = [
		'order_reference',
		'time_placed',
		'time_retrieved',
		'time_dispatched',
		'time_last_status',
		'time_delivered',
		'time_expected'
	];

	public $iteratable = true;

	public $viewable = [
		'time_placed',
		'time_retrieved',
		'time_dispatched',
		'time_last_status',
		'time_delivered',
		'time_expected'
	];

	public $editable = [];

	public $relationships = [];

	public function order()
	{
		return $this->belongsTo(\App\Models\Order::class, 'order_reference');
	}
}
