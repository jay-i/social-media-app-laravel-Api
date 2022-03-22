<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    protected $responseHelper;

    public function __construct(ResponseHelper $responseHelper)
    {
        $this->responseHelper = $responseHelper;
    }

    public function me()
    {
        $user = Auth::user();
        // return $user;

        return $this->responseHelper->successResponse(true, 'User info', $user);
    }

    public function toggleFriend($id)
    {
        
        $userFriends = auth()->user()->friends();

        if ($userFriends->find($id)) {
            $userFriends->detach([$id]);

            return $this->responseHelper->successResponse(true, 'Removed Friend', []);
        }
        
        $userFriends->attach([$id]);

        return $this->responseHelper->successResponse(true, 'Added Friend', []);
    }

    public function getFriends()
    {
        $userFriends = auth()->user()->friends()->get();

        return $this->responseHelper->successResponse(true, 'All friends', $userFriends);
    }

}
