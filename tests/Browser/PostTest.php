<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\Browser\Pages\CreatePost;
use Tests\Browser\Pages\EditPost;
use Illuminate\Foundation\Testing\WithFaker;

class PostTest extends DuskTestCase
{
    use DatabaseMigrations;
    use WithFaker;

    protected function setUp()
    {
        parent::setUp();

        $this->user = factory(\App\Models\User::class)->create();
        $this->post = resolve(\App\Repositories\Contracts\PostRepositoryInterface::class);
        factory(\App\Models\Category::class, 5)->create();
    }
    /**
     * A Dusk test example.
     *
     * @group post
     * @return void
     */
    public function testCreatePostSuccess()
    {
        $this->browse(function (Browser $browser) {
            $title = $this->faker->sentence();
            $browser->loginAs($this->user)
                    ->visit(new CreatePost)
                    ->type("@title", $title)
                    ->select('@category')
                    ->attach('@image', __DIR__ . '/bg.jpg')
                    ->check('type')
                    ->keys("@intro", $this->faker->paragraph())
                    ->keys("@content", $this->faker->paragraph())
                    ->click("@submit")
                    ->assertPathIs('/admin/posts')
                    ->assertSee($title)
                    ->logout();
        });
    }


    /**
     *
     * @group post-create-fail
     * @return void
     */
    public function testCreatePostFail()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                    ->visit(new CreatePost)
                    ->pause(500)
                    ->click("@submit")
                    ->assertPathIs('/admin/posts/create')
                    ->pause(500)
                    ->assertSee('The title field is required.')
                    ->assertSee('The intro field is required.')
                    ->assertSee('The content field is required.')
                    ->dump()
                    ->logout();
        });
    }

    
    /**
     *
     * @group edit-post
     * @return void
     */
    public function testUpdatePostSuccess()
    {
        $post = factory(\App\Models\Post::class)->create();
        $this->browse(function (Browser $browser) use ($post) {
            $title = $this->faker->sentence();
            $browser->loginAs($this->user)
                    ->visit(new EditPost($post))
                    ->type("@title", $title)
                    ->select('@category')
                    ->attach('@image', __DIR__ . '/bg.jpg')
                    ->uncheck('type')
                    ->keys("@intro", $this->faker->paragraph())
                    ->keys("@content", $this->faker->paragraph())
                    ->click("@submit")
                    ->assertPathIs('/admin/posts')
                    ->assertSee($title)
                    ->assertSee('draft')
                    ->logout();
        });
    }

    
    /**
     *
     * @group edit-post-fail
     * @return void
     */
    public function testUpdatePostFailValidate()
    {
        $post = factory(\App\Models\Post::class)->create();

        $this->browse(function (Browser $browser) use ($post) {
            $title = $this->faker->sentence();
            $browser->loginAs($this->user)
                    ->visit(new EditPost($post))
                    ->clear("@title")
                    ->keys("@intro", ['{control}', 'a'], '{delete}')
                    ->pause(500)
                    ->keys("@content", ['{control}', 'a'], '{delete}')
                    ->pause(500)
                    ->click("@submit")
                    ->assertPathIs('/admin/posts/' . $post->id . '/edit')
                    ->assertSee('The title field is required.')
                    ->assertSee('The intro field is required.')
                    ->assertSee('The content field is required.')
                    ->logout();
        });
    }

    /**
     * @group list-post
     */
    public function testListPost()
    {
        $posts = factory(\App\Models\Post::class, 22)->create();
        $this->browse(function (Browser $browser) use ($posts) {
            $title = $this->faker->sentence();
            $browser->loginAs($this->user)
                    ->visit("/admin/posts")
                    ->assertSee($posts[0]->title)
                    ->assertSee($posts[19]->title)
                    ->visit("/admin/posts?page=2")
                    ->assertSee($posts[20]->title)
                    ->assertSee($posts[21]->title)
                    ->logout();
        });
    }

    /**
     * @group list-post
     */
    public function testListPostSearch()
    {
        $posts = factory(\App\Models\Post::class, 22)->create();
        $this->browse(function (Browser $browser) use ($posts) {
            $title = $this->faker->sentence();
            $browser->loginAs($this->user)
                    ->visit("/admin/posts?title=" . urlencode($posts[0]->title))
                    ->assertSee($posts[0]->title)
                    ->assertDontSee($posts[19]->title)
                    ->logout();
        });
    }

    /**
     * @group post-delete
     */
    public function testDeletePost()
    {
        $post = factory(\App\Models\Post::class)->create();
        $this->browse(function (Browser $browser) use ($post) {
            $title = $this->faker->sentence();
            $browser->loginAs($this->user)
                    ->visit("/admin/posts")
                    ->press("Delete")
                    ->assertPathIs("/admin/posts")
                    ->assertDontSee($post->title)
                    ->logout();
        });
    }
}
