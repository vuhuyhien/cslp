<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\Models\Post::class, function (Faker $faker) {
    $category = factory(App\Models\Category::class)->create();
    
    return [
        "title" => $faker->sentence(),
        "category_id" => $category->id,
        "image" => $faker->imageUrl(),
        "type" => 1,
        "intro" => $faker->paragraph(),
        "content" => $faker->paragraph(),
    ];
});
