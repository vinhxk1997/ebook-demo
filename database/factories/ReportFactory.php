<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Report::class, function (Faker $faker) {
    return [
        'content' => $faker->paragraph,
        'status' => $faker->randomElement(['processing', 'rejected', 'resolved']),
    ];
});
