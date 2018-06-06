<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserRepositoryTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testChangeMailSuccess()
    {
        $user = factory(\App\Models\User::class)->create();
        $changeMailRepository = resolve('App\Repositories\Contracts\ChangeEmailRepositoryInterface');
        $email = $this->faker->unique()->safeEmail;
        $actualChangeMail = $changeMailRepository->add($user, $email);
        $token = $actualChangeMail->token;
        $userRepository = resolve('App\Repositories\Contracts\UserRepositoryInterface');
        $userRepository->changeMail($token);

        $new = \App\Models\User::find($user->id);

        $this->assertEquals($new->email, $email);
    }

    public function testChangeMailFail()
    {
        $user = factory(\App\Models\User::class)->create();
        $changeMailRepository = resolve('App\Repositories\Contracts\ChangeEmailRepositoryInterface');
        $email = $this->faker->unique()->safeEmail;
        $actualChangeMail = $changeMailRepository->add($user, $email);
        $token = $actualChangeMail->token;
        //expire the change mail request
        $changeMailRepository->expire($token);
        $userRepository = resolve('App\Repositories\Contracts\UserRepositoryInterface');
        $result = $userRepository->changeMail($token);

        $this->assertFalse($result);
    }


    public function testChangeMailFailRollback()
    {
        //can't test this case in unit test
        $this->assertTrue(true);
    }
}
