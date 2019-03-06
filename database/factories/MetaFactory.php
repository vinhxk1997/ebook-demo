<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Meta::class, function (Faker $faker) {
    $name = $faker->word;

    return [
        'name' => $name,
        'slug' => str_slug($name),
        'type' => $faker->randomElement(['tag', 'category']),
    ];
});
