<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 16 Oct 2017 14:12:02 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Customer
 * 
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $telephone
 * @property int $address_id
 * 
 * @property \App\Models\Address $address
 * @property \Illuminate\Database\Eloquent\Collection $orders
 *
 * @package App\Models
 */
class Customer extends Eloquent
{
	public $timestamps = false;

	protected $casts = [
		'address_id' => 'int'
	];

	protected $fillable = [
		'first_name',
		'last_name',
		'email',
		'telephone',
		'address_id'
	];

	public function address()
	{
		return $this->belongsTo(\App\Models\Address::class);
	}

	public function orders()
	{
		return $this->hasMany(\App\Models\Order::class);
	}
}
