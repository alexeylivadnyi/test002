<?php

/** @var Factory $factory */

use App\Models\Client;
use App\Models\Product;
use App\Models\Revenue;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Revenue::class, function (Faker $faker) {
    return [
        'product_id' => function () {
            if (Product::count()) {
                return Product::orderByRaw('rand()')->value('id');
            }

            return factory(Product::class)->create()->id;
        },
        'client_id'  => function () {
            if (Client::count()) {
                return Client::orderByRaw('rand()')->value('id');
            }

            return factory(Client::class)->create()->id;
        },
        'total'      => $faker->numberBetween(99, 99999),
        'date'       => $faker->dateTimeBetween('-3 month', 'now'),
    ];
});
