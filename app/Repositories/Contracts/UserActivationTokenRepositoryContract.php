<?php

namespace App\Repositories\Contracts;

interface UserActivationTokenRepositoryContract
{
    public function createToken(int $userId, $token);
    
    public function checkToken($code);
}