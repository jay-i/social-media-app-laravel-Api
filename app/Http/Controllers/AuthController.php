<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\ResponseHelper;
use App\Services\UserService;
use App\Services\PasswordResetService;
use App\Services\UserActivationTokenService;
use App\Mail\RegisterUserMail;
use App\Mail\ForgotPasswordMail;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Requests\LoginUserRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;


class AuthController extends Controller
{
    protected $userService;
    protected $responseHelper;
    protected $userActivationTokenService;
    protected $passwordResetService;

    public function __construct(UserService $userService, ResponseHelper $responseHelper, UserActivationTokenService $userActivationTokenService, PasswordResetService $passwordResetService)
    {
        $this->userService = $userService;
        $this->responseHelper = $responseHelper;
        $this->userActivationTokenService = $userActivationTokenService;
        $this->passwordResetService = $passwordResetService;
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
        $checkActivated = $this->userService->checkUserIsActivated($request->email);

        if (!$checkActivated){
            return $this->responseHelper->errorResponse(false, 'User Needs To Activate Account!', 401);
        }

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

    public function forgotPasswordCreate(Request $request)
    {
        $checkUserEmail = $this->userService->checkEmail($request->email);

        if (!$checkUserEmail) {
            return $this->responseHelper->errorResponse(false, 'User Email doesnt Exist', 401);
        }

        $passwordResetData = $this->passwordResetService->createPasswordReset($request->email);
        Mail::to($request->email)->send(new ForgotPasswordMail($passwordResetData));

        return $this->responseHelper->successResponse(true, 'Password Reset Email Sent', $passwordResetData);
    }

    public function forgotPasswordToken(Request $request, $token)
    {
        $checkToken = $this->passwordResetService->checkReset($request->email, $token);
        
        if (!$checkToken) {
            return $this->responseHelper->errorResponse(false, 'Details did not match!', 400);
        }

        $user = $this->userService->getUserByEmail($request->email);
        
        if (!$user) {
            return $this->responseHelper->errorResponse(false, 'User not found!', 401);
        }
        //put it in service
        $user->password = bcrypt($request->password);
        $user->save();

        //put it in service
        $checkToken->delete();        

        return $this->responseHelper->successResponse(true, 'Password Reset Successful', $user);
    }
}
