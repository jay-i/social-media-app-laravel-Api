<?php

namespace App\Repositories\Contracts;

interface UserRepositoryContract
{
    public function registerUser(array $data);

    public function activateUser(int $userId);

    public function checkIfUserEmailExists($email);

    public function getUserByEmail($email);
}