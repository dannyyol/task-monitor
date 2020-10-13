<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Task;
use Faker\Generator as Faker;

$factory->define(Task::class, function (Faker $faker) {
    $startingDate = $faker->dateTimeBetween('this week', '+6 days');
    $endingDate   = $faker->dateTimeBetween($startingDate, strtotime('+6 days'));

    return [
        'task_name' => $faker->word(),
        'description' => $faker->paragraph(2),
        'status' => $faker->numberBetween(0,1),
        'start_date' => $startingDate,
        'end_date' => $endingDate,
    ];
});