<?php

use Faker\Generator as Faker;

$factory->define(App\Models\SaveList::class, function (Faker $faker) {
    return [
        'name' => $faker->text(31),
    ];
});
