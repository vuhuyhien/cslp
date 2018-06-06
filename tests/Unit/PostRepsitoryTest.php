<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PostRepsitoryTest extends TestCase
{
    public function setUp()
    {
        $this->post = resolve(App\Repositories\Contracts\PostRepositoryInterface::class);
    }
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testSearch()
    {
        $this->assertTrue(true);
    }
}
