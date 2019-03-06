<?php

use Faker\Generator as Faker;

$factory->define(App\Models\UserProfile::class, function (Faker $faker) {
    return [
        'address' => $faker->address,
        'about' => $faker->text(200),
        'website' => $faker->domainName,
    ];
});
