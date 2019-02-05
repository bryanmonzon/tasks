<?php

use Faker\Generator as Faker;

$factory->define(App\Task::class, function (Faker $faker) {
    return [
        'user_id' => rand(1,11),
        'project_id' => rand(1,10),
        'body' => $faker->sentence,
        'hours' => rand(1,8),
        'completed' => $faker->boolean,
        'due_date' => $faker->dateTimeBetween('+0 days', '+1 week'),
        'client_reviewed' => $faker->boolean,
        'client_approved' => $faker->boolean,
    ];
});
