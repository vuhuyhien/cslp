<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;
use Laravel\Dusk\Page as BasePage;

class EditPost extends BasePage
{

    public function __construct(\App\Models\Post $post)
    {
        $this->post = $post;
    }
    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return '/admin/posts/'. $this->post->id . '/edit';
    }

    /**
     * Assert that the browser is on the page.
     *
     * @param  Browser  $browser
     * @return void
     */
    public function assert(Browser $browser)
    {
        $browser->assertPathIs($this->url());
    }

    /**
     * Get the element shortcuts for the page.
     *
     * @return array
     */
    public function elements()
    {
        return [
            '@title' => 'input[name="title"]',
            '@category' => '#posts-category',
            '@image' => '#posts-image',
            '@type' => '#posts-public',
            '@intro' => 'div.intro + div .note-editable.card-block',
            '@content' => 'div.content + div .note-editable.card-block',
            '@submit' => '#posts-create-submit'
        ];
    }
}
