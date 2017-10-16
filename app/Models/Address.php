<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 16 Oct 2017 14:12:02 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Address
 * 
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $line_1
 * @property string $line_2
 * @property string $line_3
 * @property string $city
 * @property string $region
 * @property string $postal_code
 * @property string $country_code
 * 
 * @property \Illuminate\Database\Eloquent\Collection $customers
 * @property \Illuminate\Database\Eloquent\Collection $orders
 *
 * @package App\Models
 */
class Address extends Eloquent
{
	public $timestamps = false;

	protected $fillable = [
		'first_name',
		'last_name',
		'line_1',
		'line_2',
		'line_3',
		'city',
		'region',
		'postal_code',
		'country_code'
	];

	public function customers()
	{
		return $this->hasMany(\App\Models\Customer::class);
	}

	public function orders()
	{
		return $this->hasMany(\App\Models\Order::class);
	}
}
