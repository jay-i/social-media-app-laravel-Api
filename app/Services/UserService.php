<?php

namespace App\Services;

use App\Repositories\Contracts\UserRepositoryContract;
use Illuminate\Support\Facades\Auth;

class UserService
{
    protected $userRepositoryContract;
    
    public function __construct(UserRepositoryContract $userRepositoryContract)
    {
        $this->userRepositoryContract = $userRepositoryContract;
    }

    public function registerUser(array $data)
    {
        $userData = [
            'username' => $data['username'],
            'email' =>  $data['email'],
            'password' => bcrypt($data['password'])
        ];

        $newUser = $this->userRepositoryContract->registerUser($userData);

        return $newUser;
    }

    public function loginUser(array $data)
    {
        // dd($data['username']);
        if (Auth::attempt(['username' => $data['username'], 'password' => $data['password']]))
        {
            $user = Auth::user();
            return $user;
        }

        return false;
    }
}