<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 16 Oct 2017 14:12:02 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Courier
 * 
 * @property string $code
 * @property string $name
 * @property int $max_weight
 * @property int $max_length
 * @property int $split_weight
 * @property float $min_order_value
 * @property float $max_order_value
 * @property float $service_cost
 * @property string $available_services
 * @property bool $integrated
 * @property bool $international
 * @property bool $recorded
 * 
 * @property \Illuminate\Database\Eloquent\Collection $orders
 *
 * @package App\Models
 */
class Courier extends Eloquent
{
	protected $primaryKey = 'code';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'max_weight' => 'int',
		'max_length' => 'int',
		'split_weight' => 'int',
		'min_order_value' => 'float',
		'max_order_value' => 'float',
		'service_cost' => 'float',
		'integrated' => 'bool',
		'international' => 'bool',
		'recorded' => 'bool'
	];

	protected $fillable = [
		'name',
		'max_weight',
		'max_length',
		'split_weight',
		'min_order_value',
		'max_order_value',
		'service_cost',
		'available_services',
		'integrated',
		'international',
		'recorded'
	];

	public function orders()
	{
		return $this->hasMany(\App\Models\Order::class, 'courier_code');
	}
}
