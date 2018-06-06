<?php

namespace App\Repositories\Eloquent;

use App\Models\ChangeEmail;
use App\Models\User;
use App\Repositories\Contracts\ChangeEmailRepositoryInterface;

class ChangeEmailRepository extends BaseRepository implements ChangeEmailRepositoryInterface
{
    public function model() {
        return ChangeEmail::class;
    }

    public function add(User $user, $email)
    {
        return $this->create([
            'user_id' => $user->id,
            'token' => uniqid('email', true),
            'email' => $email,
        ]);
    }

    public function findByToken($token)
    {
        return $this->model->where('token', $token)
                ->where('is_expired', 0)
                ->orderBy('created_at', 'desc')
                ->first();
    }

    public function expire($token)
    {
        $changeEmail = $this->findBy('token', $token);
        $changeEmail->is_expired = 1;
        $changeEmail->save();
    }
}