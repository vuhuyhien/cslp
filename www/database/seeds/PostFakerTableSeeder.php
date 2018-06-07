<?php

// use Config;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostFakerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Models\Post::class, 30)->create();
    }
}
