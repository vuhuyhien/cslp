<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class LoginTest extends DuskTestCase
{
    use DatabaseMigrations;
    /**
     * A Dusk test example.
     * @group login
     * @return void
     */
    public function testLoginSuccess()
    {

        $user = factory(\App\Models\User::class)->create([
            'email' => 'taylor@laravel.com',
        ]);

        $this->browse(function (Browser $browser) use ($user){
            $browser->visit('/admin/login')
                    ->type('email', $user->email)
                    ->type('password', 'secret')
                    ->press('Login')
                    ->assertPathIs('/admin')
                    ->logout();
        });
    }

    /**
     * @group login
     */
    public function testLoginFailCauseValidate()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/login')
                    ->press('Login')
                    ->assertSee('The email field is required.')
                    ->assertSee('The password field is required.');
        });
    }

    /**
     * @group login
     */
    public function testLoginFailWrongInformation()
    {
        //These credentials do not match our records.
        $user = factory(\App\Models\User::class)->create([
            'email' => 'taylor@laravel.com',
        ]);

        $this->browse(function (Browser $browser) use ($user){
            $browser->visit('/admin/login')
                    ->type('email', str_random(12))
                    ->type('password', str_random(12))
                    ->press('Login')
                    ->assertSee('These credentials do not match our records.');
        });
    }
}
