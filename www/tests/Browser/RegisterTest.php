<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\Browser\Pages\Register;

class RegisterTest extends DuskTestCase
{
    use DatabaseMigrations;
    /**
     * A Dusk test example.
     *
     * @group register
     * @return void
     */
    public function testRegisterSuccess()
    {
        $user = factory(\App\Models\User::class)->make();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->visit(new Register)
                    ->type('@name', $user->name)
                    ->type('@email', $user->email)
                    ->type('@password', 'secret')
                    ->type('@password_confirmation', 'secret')
                    ->press('Register')
                    ->assertPathIs('/admin')
                    ->screenshot("testRegisterSuccess")
                    ->logout();
        });
    }

    /**
     * @group register
     */
    public function testRegisterFailValidateBlank()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Register)
                    ->press('Register')
                    ->assertSee('The name field is required.')
                    ->assertSee('The email field is required.')
                    ->assertSee('The password field is required.')
                    ->screenshot("testRegisterFailValidateBlank");
        });
    }

    /**
     * @group register
     */
    public function testRegisterFailValidatePasswordConfirmationAndEmailFormat()
    {
        $user = factory(\App\Models\User::class)->make();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->visit(new Register)
                    ->type('@name', $user->name)
                    ->type('@email', $user->name)
                    ->type('@password', 'secret')
                    ->type('@password_confirmation', 'secret123')
                    ->press('Register')
                    ->assertSee('The password confirmation does not match.')
                    ->assertSee('The email must be a valid email address.')
                    ->screenshot("testRegisterFailValidatePasswordConfirmationAndEmailFormat");
        });
    }
}
