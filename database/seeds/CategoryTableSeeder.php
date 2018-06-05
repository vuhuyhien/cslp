<?php

// use Config;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('category')->insert([
            'name' => config('constants.CATEGORY_DEFAULT'),
            'alias' => str_slug(config('constants.CATEGORY_DEFAULT')),
            'description' => '',
        ]);
    }
}
