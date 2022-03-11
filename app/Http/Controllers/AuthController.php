<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Services\UserService;
use App\Services\UserActivationTokenService;
use App\Mail\RegisterUserMail;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Requests\LoginUserRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;


class AuthController extends Controller
{
    protected $userService;
    protected $responseHelper;
    protected $userActivationTokenService;

    public function __construct(UserService $userService, ResponseHelper $responseHelper, UserActivationTokenService $userActivationTokenService)
    {
        $this->userService = $userService;
        $this->responseHelper = $responseHelper;
        $this->userActivationTokenService = $userActivationTokenService;
    }

    public function register(RegisterUserRequest $request)
    {
        $user = $this->userService->registerUser($request->all());

        if ($user) {
            $token = $this->userActivationTokenService->createNewToken($user->id);
            Mail::to($user->email)->send(new RegisterUserMail($user, $token->token));
            return $this->responseHelper->successResponse(true, 'Register Eail Sent', $user);
        }

        return $this->responseHelper->errorResponse(false, 'No user created', 404);


    }

    public function login(LoginUserRequest $request)
    {
        $newUser = $this->userService->loginUser($request->all());

        if ($newUser) {
            $token = $newUser->createToken('mywebsiteapp');

            return response()->json([
                'access_token' => $token->accessToken,
                'token_type' => 'Bearer',
                'expire_date' => $token->token->expires_at,
                'user' => $newUser
            ]);
        }

        return $this->responseHelper->errorResponse(false, 'Unauthorised', 401);
    }

    public function me()
    {
        $user = Auth::user();

        return $this->responseHelper->successResponse(true, 'User', $user);
    }

    public function activateEmail($code)
    {
        $checkToken = $this->userActivationTokenService->checkToken($code);

        return $this->responseHelper->successResponse(true, 'Activate Email', $checkToken);
    }
}
