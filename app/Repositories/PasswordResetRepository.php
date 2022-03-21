<?php

namespace App\Repositories;

use Illuminate\Support\Str;
use App\Models\PasswordReset;
use App\Repositories\Contracts\PasswordResetRepositoryContract;

class PasswordResetRepository implements PasswordResetRepositoryContract  
{
   public function createPasswordReset($email)
   {
      try {

         $newReset = PasswordReset::updateOrCreate(
            ['email' => $email],
            [
               'email' => $email,
               'token' => Str::random(20)
            ]
         );

         return $newReset;

      } catch (\Exception $e) {
         return $e->getMessage();
      }
   }

   public function checkReset($email, $token)
   {
      return PasswordReset::where(['token' => $token,'email' => $email])->first();
   }
}