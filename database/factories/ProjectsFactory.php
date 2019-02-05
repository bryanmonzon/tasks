<?php

use Faker\Generator as Faker;

$factory->define(App\Project::class, function (Faker $faker) {
    return [
        'name' => $faker->company,
        'status' => $faker->randomElement(['active', 'pending', 'complete'])
    ];
});
