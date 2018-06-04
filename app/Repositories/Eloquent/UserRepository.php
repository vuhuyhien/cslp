<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Contracts\UserRepositoryInterface;
use App\Models\User;
use App\Models\OauthAccessToken;
use Log;
use Hash;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    public function model() {
        return User::class;
    }

    /**
     * create new user
     * @param array $data
     * @return App\Models\User | null
     */
    public function regist(array $data) {
        Log::info('create user with info: ' . print_r($data, true));
        $data['id'] = uniqid(null, true);
        $data['password'] = app('hash')->make($data['password']);
        $verify_code = mt_rand(100000, 999999);
        $data['verify_code'] = $verify_code;

        return $this->create($data);
    }

    /**
     * get user to login
     * @param string $email
     * @param string $plainPassword
     * @return App\Models\User | null
     */
    public function getUserByCredential(string $email, string $plainPassword) {
        Log::info('get user login by email:' . $email);
        $user = $this->findBy('email', $email);
        if(is_null($user) || !app('hash')->check($plainPassword, $user->password)) {
            Log::info('user do not exist:(email: ' . $email . ', password: '. $plainPassword . ')');
            return null;
        }

        if(!$user->is_active) {
            Log::info('user neither active or confirm:' . print_r($user, true));    
            return null;
        }

        Log::info('found user:' . print_r($user, true));
        
        return $user;
    }

    /**
     * save user access token
     * @param User $user
     * @param array $token
     * @return User
     */
    public function saveToken(User $user, array $token) {
        Log::info('save access token for user: ' . $user->id . ' with token: '. print_r($token, true));
        $tokenModel = new OauthAccessToken($token);
        $user->tokens()->save($tokenModel);

        return $user;
    }

    /**
     * find user with access token
     * @param string $accessToken
     */
    public function getUserByToken(string $accessToken) {
        Log::info("find user with access token:" . $accessToken);
        $token = OauthAccessToken::where('access_token', $accessToken)
                                    ->orderBy('created_at', 'DESC')
                                    ->first();
        if(is_null($token)) {
            Log::info("not found user with access token: " . $accessToken);
            return null;
        }

        Log::info("found user: ". print_r($token->user, true));
        if(!is_null($token)) {
            $user = $token->user;
            // if($user->is_active && $user->is_confirm) {
                // return $user;
            // }

            return $user;
        }

        return null;
    }

    /**
     * verify user
     * @param mix $data [<phone_number>, <verify_code>]
     */
    public function verifyUser($data) {
        Log::info("find user: ". print_r($data, true));
        $user = User::where('phone_number', $data['phone_number'])
                    ->where('verify_code', $data['verify_code'])
                    ->where('is_confirm', 0)
                    ->where('is_active', 1)
                    ->first();
        
        if(!is_null($user)) {
            $user->is_confirm = 1;
            $user->verify_code = null;
            $user->save();
        }

        Log::info("user verified: ". print_r($user, true));

        return $user;
    }
}