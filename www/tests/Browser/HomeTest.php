<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;

class HomeTest extends DuskTestCase
{

    use DatabaseMigrations;
    use WithFaker;
    /**
     * A Dusk test example.
     *
     * @group home
     * @return void
     */
    public function testViewPosts()
    {
        $posts = factory(\App\Models\Post::class, 22)->create();
        $this->browse(function (Browser $browser) use ($posts) {
            $title = $this->faker->sentence();
            $browser->visit("/")
                    ->assertSee($posts[0]->title)
                    ->assertSee($posts[19]->title)
                    ->visit("/?page=2")
                    ->assertSee($posts[20]->title)
                    ->assertSee($posts[21]->title);
        });
    }

    /**
     * A Dusk test example.
     *
     * @group single-post
     * @return void
     */
    public function testViewSinglePost()
    {
        $posts = factory(\App\Models\Post::class, 22)->create();
        $this->browse(function (Browser $browser) use ($posts) {
            $title = $this->faker->sentence();
            $browser->visit("/view/" . $posts[0]->id)
                    ->assertSee($posts[0]->title)
                    ->assertSee($posts[0]->intro)
                    ->assertSee($posts[0]->content);
        });
    }

    /**
     * A Dusk test example.
     *
     * @group category-post
     * @return void
     */
    public function testViewCategoryPost()
    {
        
        $category = factory(\App\Models\Category::class)->create();
        $post = factory(\App\Models\Post::class)->create([
            "category_id" => $category->id
        ]);
        $this->browse(function (Browser $browser) use ($post, $category) {
            $title = $this->faker->sentence();
            $browser->visit("/?category=" . $category->alias)
                    ->assertSee($post->title)
                    ->assertSee($post->intro);
        });
    }
}
