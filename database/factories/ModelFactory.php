<?php
/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/
/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Order::class, function (Faker\Generator $faker) {
    $customer = factory(App\Models\Customer::class)->create();
    return [
        'order_id' => $faker->ean8,
        'source' => $faker->randomElement(['eBay', 'Amazon', 'Magento']),
        'account' => $faker->randomElement(['Elixir', 'ProSalt']),
        'total_price' => $faker->randomFloat(2, 1, 999),
        'service' => $faker->randomElement(['Standard', 'Expedited']),
        'status' => $faker->optional(0.9)->randomElement(['Generated', 'Printed', 'Scanned', 'Dispatched', 'Void']),
        'parcel_count' => $faker->optional(0.3, 1)->numberBetween(1, 8),
        'weight' => $faker->numberBetween(100, 40000),
        'length' => $faker->numberBetween(1, 300),
        'order_message' => $faker->optional(0.3)->sentence(8),
        'courier_code' => $faker->randomElement(['RM', 'H', 'YPK', 'Y72', 'Y24', 'H24', 'T', 'SFP', 'INT']),
        'customer_id' => $customer->id,
        'address_id' => $customer->address_id
    ];
});

$factory->define(App\Models\Ordertime::class, function (Faker\Generator $faker) {
    $time_placed = $faker->dateTimeBetween('-7 days', '-1 days');
    $time_retrieved = $faker->dateTimeBetween($time_placed->format('Y-m-d H:i:s'), '-1 hours');
    $time_dispatched = $faker->optional(0.3)->dateTimeBetween($time_retrieved->format('Y-m-d H:i:s'), 'now');
    $time_last_status = null;
    $time_delivered = null;
    if (!is_null($time_dispatched)) {
        $time_last_status = $faker->optional(0.1)->dateTimeBetween($time_dispatched->format('Y-m-d H:i:s'), 'now');
        $time_delivered = $faker->optional(0.1)->dateTimeBetween($time_dispatched->format('Y-m-d H:i:s'), 'now');
    }

    return [
        'time_placed' => $time_placed,
        'time_retrieved' => $time_retrieved,
        'time_dispatched' => $time_dispatched,
        'time_last_status' => $time_last_status,
        'time_delivered' => $time_delivered,
        'time_expected' => $faker->dateTimeBetween($time_placed->format('Y-m-d H:i:s')." + 1 days", $time_placed->format('Y-m-d H:i:s')." + 6 days")
    ];
});

$factory->define(App\Models\Tracking::class, function (Faker\Generator $faker) {
    return [
        'tracking_number' => $faker->isbn13
    ];
});

$factory->define(App\Models\Customer::class, function (Faker\Generator $faker) {
    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'email' => $faker->unique()->safeEmail,
        'telephone' => $faker->phoneNumber,
        'address_id' => factory(App\Models\Address::class)->create()->id
    ];
});

$factory->define(App\Models\Address::class, function (Faker\Generator $faker) {
    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'line_1' => $faker->streetAddress,
        'line_2' => $faker->secondaryAddress,
        'city' => $faker->city,
        'region' => $faker->county,
        'postal_code' => $faker->postcode,
        'country_code' => 'GB'
    ];
});

$factory->define(App\Models\Product::class, function (Faker\Generator $faker) {
    return [
        'sku' => factory(App\Models\Inventory::class)->create()->sku,
        'id' => $faker->ean8,
        'image_url' => $faker->imageUrl,
        'name' => $faker->sentence(8),
        'price' => $faker->randomFloat(2, 1, 999),
        'shipping' => $faker->randomFloat(2, 1, 15),
        'quantity' => $faker->optional(0.3, 1)->numberBetween(1, 8)
    ];
});

$factory->define(App\Models\Inventory::class, function (Faker\Generator $faker) {
    return [
        'sku' => $faker->bothify('????_##_#'),
        'parent_sku' => $faker->optional(0.5)->bothify('????_##_#'),
        'weight' => $faker->numberBetween(100, 40000),
        'length' => $faker->numberBetween(1, 300),
        'name' => $faker->sentence(8),
        'sku_is_generated' => $faker->boolean()
    ];
});