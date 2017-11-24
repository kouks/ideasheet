<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Idea::class, function (Faker $faker) {
    return [
        'user_id' => 1,
        'content' => $faker->paragraph,
        'query' => $faker->slug,
        'color' => 'white',
        'featured' => ! rand(0, 4),
    ];
});

$factory->define(App\Models\Tag::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
    ];
});

$factory->define(App\Models\Attachment::class, function (Faker $faker) {
    return [
        'idea_id' => 1,
        'type' => rand(0, 2),
        'content' => $faker->slug,
    ];
});
