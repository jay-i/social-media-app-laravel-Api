<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use App\Repositories\Contracts\PasswordResetRepositoryContract;

class PasswordResetService
{
    protected $passwordResetRepositoryContract;

    public function __construct(PasswordResetRepositoryContract $passwordResetRepositoryContract)
    {
        $this->passwordResetRepositoryContract = $passwordResetRepositoryContract;
    }

    public function createPasswordReset($email)
    {
        return $this->passwordResetRepositoryContract->createPasswordReset($email);
    }

    public function checkReset($email, $token)
    {
        return $this->passwordResetRepositoryContract->checkReset($email, $token);
    }
}