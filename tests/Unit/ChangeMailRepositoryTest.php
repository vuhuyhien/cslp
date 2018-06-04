<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ChangeMailRepositoryTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCreateChangeMail()
    {
        $user = factory(\App\Models\User::class)->create();
        $changeMailRepository = resolve('App\Repositories\Contracts\ChangeEmailRepositoryInterface');
        $email = $this->faker->unique()->safeEmail;
        $actualChangeMail = $changeMailRepository->add($user, $email);
        if($actualChangeMail)
            $actualEmail = $actualChangeMail->email;
        else 
            $actualEmail = '';

        $this->assertEquals($email, $actualEmail);
    }

    public function testFindByToken()
    {
        $user = factory(\App\Models\User::class)->create();
        $changeMailRepository = resolve('App\Repositories\Contracts\ChangeEmailRepositoryInterface');
        $email = $this->faker->unique()->safeEmail;
        $expectChangeMail = $changeMailRepository->add($user, $email);

        $actualChangeMail = $changeMailRepository->findByToken($expectChangeMail->token);
        $actualData = [
            'user_id' => $actualChangeMail->user_id,
            'email' => $actualChangeMail->email,
            'token' => $actualChangeMail->token,
            'expired' => $actualChangeMail->expire
        ];

        $expextData = [
            'user_id' => $expectChangeMail->user_id,
            'email' => $expectChangeMail->email,
            'token' => $expectChangeMail->token,
            'expired' => $expectChangeMail->expire
        ];

        $this->assertEquals($actualData, $expextData);
    }

    public function testExpireEmail()
    {
        $user = factory(\App\Models\User::class)->create();
        $changeMailRepository = resolve('App\Repositories\Contracts\ChangeEmailRepositoryInterface');
        $email = $this->faker->unique()->safeEmail;
        $actualChangeMail = $changeMailRepository->add($user, $email);
        $changeMailRepository->expire($actualChangeMail->token);
        $expiredChangeMail = $changeMailRepository->findByToken($actualChangeMail->token);

        $this->assertEquals(null, $expiredChangeMail);
    }

    
}
