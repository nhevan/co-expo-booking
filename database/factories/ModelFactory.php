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
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Event::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'short_address' => $faker->streetAddress,
        'address' => $faker->address,
        'info' => $faker->sentence(2),
        'start_date' => $faker->dateTime,
        'end_date' => $faker->dateTime,
        'latitude' => $faker->latitude(40.713040, 40.719050),
        'longitude' => $faker->longitude(-74.003000, -74.009000),
        'blueprint_img' => '/images/hall-map.png',
    ];
});


$factory->define(App\Stand::class, function (Faker\Generator $faker) {
    return [
        'stand_number' => $faker->numberBetween(1, 50),
        'event_id' => function(){
            return factory('App\Event')->create()->id;
        },
        'image' => $faker->imageUrl,
        'description' => $faker->sentence(3),
        'price' => $faker->numberBetween(200, 1000),
        'length' => $faker->numberBetween(100, 250),
        'breadth' => $faker->numberBetween(200, 350),
        'x_cord' => $faker->numberBetween(10, 650),
        'y_cord' => $faker->numberBetween(10, 380),
        'is_booked' => false,
    ];
});

$factory->define(App\Company::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->company,
        'stand_id' => function(){
            return factory('App\Stand')->create()->id;
        },
        'logo' => $faker->imageUrl(128, 128),
        'address' => $faker->address,
        'phone' => $faker->e164PhoneNumber,
        'admin_name' => $faker->name,
        'admin_email' => $faker->freeEmail
    ];
});