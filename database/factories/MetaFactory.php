<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Meta::class, function (Faker $faker) {
    $alphabet = 'abcdefghijklmnopqrstuvwxyz';
    $name = $faker->word . $alphabet{rand(0, strlen($alphabet) - 1)};

    return [
        'name' => $name,
        'slug' => str_slug($name),
        'type' => $faker->randomElement(['tag', 'category']),
    ];
});
