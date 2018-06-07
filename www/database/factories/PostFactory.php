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
    $randomCategory = App\Models\Category::inRandomOrder()->first();
    $count = App\Models\Category::count();
    if(!$randomCategory || $count < 5) {
        $name = $faker->sentence(2);
        $randomCategory = factory(App\Models\Category::class)->create([
            'name' => $name,
            'alias' => str_slug($name)
        ]);    
    }
    
    return [
        "title" => $faker->sentence(),
        "category_id" => $randomCategory->id,
        "image" => $faker->imageUrl(),
        "type" => 1,
        "intro" => $faker->paragraph(),
        "content" => $faker->paragraph(),
    ];
});
