<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

            DB::table('couriers')->insert([
               'code' => 'RM',
               'name' => 'Royal Mail Large Letter',
               'max_weight' => 750,
               'max_length' => 25,
               'split_weight' => null,
               'min_order_value' => null,
               'max_order_value' => 32,
               'service_cost' => 1,
               'available_services' => 'standard',
               'integrated' => true,
               'international' => false,
               'recorded' => false,
           ]);
           DB::table('couriers')->insert([
               'code' => 'H',
               'name' => 'MyHermes 3-5 Day 0-1kg',
               'max_weight' => 850,
               'max_length' => 120,
               'split_weight' => null,
               'min_order_value' => null,
               'max_order_value' => null,
               'service_cost' => 2,
               'available_services' => 'standard',
               'integrated' => true,
               'international' => false,
               'recorded' => true,
           ]);
           DB::table('couriers')->insert([
               'code' => 'YPK',
               'name' => 'Yodel "Packet"',
               'max_weight' => 2800,
               'max_length' => 35,
               'split_weight' => null,
               'min_order_value' => null,
               'max_order_value' => null,
               'service_cost' => 3,
               'available_services' => 'standard',
               'integrated' => true,
               'international' => false,
               'recorded' => true,
           ]);
           DB::table('couriers')->insert([
               'code' => 'Y72',
               'name' => 'Yodel @Home 72',
               'max_weight' => 31000,
               'max_length' => 150,
               'split_weight' => 26000,
               'min_order_value' => null,
               'max_order_value' => null,
               'service_cost' => 5,
               'available_services' => 'standard',
               'integrated' => true,
               'international' => false,
               'recorded' => true,
           ]);
           DB::table('couriers')->insert([
               'code' => 'Y24',
               'name' => 'Yodel @Home 24',
               'max_weight' => 31000,
               'max_length' => 150,
               'split_weight' => 26000,
               'min_order_value' => null,
               'max_order_value' => null,
               'service_cost' => 7,
               'available_services' => 'standard, expedited',
               'integrated' => true,
               'international' => false,
               'recorded' => true,
           ]);
           DB::table('couriers')->insert([
               'code' => 'H24',
               'name' => 'MyHermes 24',
               'max_weight' => 30000,
               'max_length' => 300,
               'split_weight' => null,
               'min_order_value' => null,
               'max_order_value' => null,
               'service_cost' => 8,
               'available_services' => 'standard, expedited',
               'integrated' => true,
               'international' => false,
               'recorded' => true,
           ]);
           DB::table('couriers')->insert([
               'code' => 'T',
               'name' => 'Tuffnells',
               'max_weight' => 31000,
               'max_length' => 350,
               'split_weight' => null,
               'min_order_value' => null,
               'max_order_value' => null,
               'service_cost' => 9,
               'available_services' => 'standard, expedited',
               'integrated' => false,
               'international' => false,
               'recorded' => true,
           ]);
           DB::table('couriers')->insert([
               'code' => 'SFP',
               'name' => 'Prime Logistics',
               'max_weight' => 23000,
               'max_length' => 120,
               'split_weight' => null,
               'min_order_value' => null,
               'max_order_value' => null,
               'service_cost' => 1,
               'available_services' => 'sfp',
               'integrated' => false,
               'international' => false,
               'recorded' => true,
           ]);
           DB::table('couriers')->insert([
               'code' => 'INT',
               'name' => 'International',
               'max_weight' => null,
               'max_length' => null,
               'split_weight' => null,
               'min_order_value' => null,
               'max_order_value' => null,
               'service_cost' => 1,
               'available_services' => null,
               'integrated' => false,
               'international' => true,
               'recorded' => true,
           ]);
        $orders = factory(App\Models\Order::class, 100)->create()->each(function($order) {
        	$order->ordertime()->save(factory(App\Models\Ordertime::class)->make());
        	if (mt_rand(0, 1) === 0) {
	        	$order->trackings()->saveMany(factory(App\Models\Tracking::class, mt_rand(1, 3))->make());
	        }
	        $order->save();
        	$order->products()->saveMany(factory(App\Models\Product::class, mt_rand(1, 5))->make());
        });
    }
}
