<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\Browser\Pages\CreateCategory;
use Illuminate\Foundation\Testing\WithFaker;

class CategoryTest extends DuskTestCase
{

    use DatabaseMigrations;
    use WithFaker;

    protected function setUp()
    {
        parent::setUp();
        $this->user = factory(\App\Models\User::class)->create();
    }
    /**
     * A Dusk test example.
     * @group category
     * @return void
     */
    public function testCreateCategorySuccess()
    {
        $this->browse(function (Browser $browser) {
            $name = $this->faker->sentence();
            $des = $this->faker->paragraph();
            $browser->loginAs($this->user)
                    ->visit(new CreateCategory)
                    ->type('@name', $name)
                    ->type('@description', $des)
                    ->press('Submit')
                    ->assertPathIs('/admin/category')
                    ->assertSee($name)
                    ->assertSee(str_slug($name))
                    ->assertSee($des)
                    ->screenshot("testCreateCategorySuccess");
        });
    }

    /**
     * A Dusk test example.
     * @group category
     * @return void
     */
    public function testCreateCategoryFail()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                    ->visit(new CreateCategory)
                    ->press('Submit')
                    ->assertSee("The name field is required.")
                    ->screenshot("testCreateCategoryFail");
        });
    }

    /**
     * A Dusk test example.
     * @group category
     * @return void
     */
    public function testCreateCategoryFailExist()
    {
        $category = factory(\App\Models\Category::class)->create();

        $this->browse(function (Browser $browser) use ($category) {
            $browser->loginAs($this->user)
                    ->visit(new CreateCategory)
                    ->type('@name', $category->name)
                    ->press('Submit')
                    ->assertSee("The name has already been taken.")
                    ->screenshot("testCreateCategoryFailExist");
        });
    }

    /**
     * A Dusk test example.
     * @group category-delete
     * @return void
     */
    public function testDeleteCategory()
    {
        $category = factory(\App\Models\Category::class)->create();

        $this->browse(function (Browser $browser) use ($category) {
            $browser->loginAs($this->user)
                    ->visit('/admin/category')
                    ->click('#delete-'.$category->id)
                    ->assertPathIs('/admin/category')
                    ->assertDontSee($category->name)
                    ->screenshot("testDeleteCategory");
        });
    }

    /**
     * A Dusk test example.
     * @group category-delete
     * @return void
     */
    public function testCantDeleteDefaultCategory()
    {
        $category = resolve(\App\Repositories\Contracts\CategoryRepositoryInterface::class);
        $this->browse(function (Browser $browser) use ($category) {
            $browser->loginAs($this->user)
                    ->visit('/admin/category')
                    ->click('#delete-'.$category->getDefaultId())
                    ->assertPathIs('/admin/category')
                    ->assertSee(config('constants.CATEGORY_DEFAULT'))
                    ->screenshot("testCantDeleteDefaultCategory");
        });
    }
}
