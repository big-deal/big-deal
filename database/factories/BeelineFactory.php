<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Beeline::class, function (Faker $faker) {
    return [
            'token' => $faker->uuid,
        ] + (rand(0, 1) ? [
            'subscribe_id' => $faker->uuid,
        ] : []);
});
