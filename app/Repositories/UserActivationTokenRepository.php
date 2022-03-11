<?php

namespace App\Repositories;

use App\Repositories\Contracts\UserActivationTokenRepositoryContract;
use App\Models\UserActivationToken;

class UserActivationTokenRepository implements UserActivationTokenRepositoryContract  
{
   public function createToken(int $userId, $token)
   {
       try{
         $newToken = new UserActivationToken();
         $newToken->user_id = $userId;
         $newToken->token = $token;
         $newToken->save();

         return $newToken;

       }catch (\Exception $e){
         return $e->getMessage();
       }
   }

   public function checkToken($code)
   {
      try{
         $checkToken = UserActivationToken::where(['token' => $code])->first();

         return $checkToken;
      }catch (\Exception $e){
         return $e->getMessage();
      }
   }
}