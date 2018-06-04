<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Contracts\UserRepositoryInterface;
use App\Models\User;
use Log;
use Hash;
use DB;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    public function model() {
        return User::class;
    }

    /**
     * change email of user
     * 
     * @param uid $token
     * @return mixed
     */
    public function changeMail($token) {
        $changeEmail = resolve('App\Repositories\Contracts\ChangeEmailRepositoryInterface');
        $newEmail = $changeEmail->findByToken($token);

        if ($newEmail) {
            DB::beginTransaction();
            try {
                $data = ['email' => $newEmail->email];
                $user = $this->update($data, $newEmail->user_id);
                $changeEmail->expire($token);
                DB::commit();

                return true;
            } catch (Exception $e) {
                DB::rollback();
                Log::error(__CLASS__ . ':' . __METHOD__ . ':' . $e->getMessage());
                return false;
            }
        } else {
            return false;
        }
    }
}