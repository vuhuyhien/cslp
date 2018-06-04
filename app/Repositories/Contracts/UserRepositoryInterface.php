<?php

namespace App\Repositories\Contracts;

interface UserRepositoryInterface
{
    /**
     * regist an user
     * @param array
     * @return App\Models\User
     */
    public function regist(array $data);
    
    /**
     * check user login
     * @param string
     * @param string
     * @return App\Models\User
     */
    public function getUserByCredential(string $email, string $passwordHash);
}