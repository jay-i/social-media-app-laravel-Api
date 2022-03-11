<?php

namespace App\Services;

use Illuminate\Support\Str;
use App\Repositories\Contracts\UserRepositoryContract;
use App\Repositories\Contracts\UserActivationTokenRepositoryContract;


class UserActivationTokenService
{
    protected $userActivationTokenRepositoryContract;
    protected $userRepositoryContract;
    
    public function __construct(UserActivationTokenRepositoryContract $userActivationTokenRepositoryContract, UserRepositoryContract $userRepositoryContract)
    {
        $this->userActivationTokenRepositoryContract = $userActivationTokenRepositoryContract;
        $this->userRepositoryContract = $userRepositoryContract;
    }

    public function createNewToken(int $userId)
    {
        $token = Str::random(20);

        return $this->userActivationTokenRepositoryContract->createToken($userId, $token);
    }

    public function checkToken($code)
    {
        $checkToken = $this->userActivationTokenRepositoryContract->checkToken($code);

        if ($checkToken) {
            $userId = $checkToken->user_id;

            $this->userRepositoryContract->activateUser($userId);
            
            $checkToken->delete();

            return response()->json([
                'message' => 'User has been activated!'
            ]);
        }

        return response()->json([
            'message' => 'User has not been activated!'
        ], 401);
    }
}