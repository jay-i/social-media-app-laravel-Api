<?php

namespace App\Repositories\Contracts;

interface PasswordResetRepositoryContract
{
    public function createPasswordReset($email);

    public function checkReset($email, $token);
}