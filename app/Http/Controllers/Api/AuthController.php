<?php


namespace App\Http\Controllers\Api;

use App\Http\ApiResponse;
use App\Http\Requests\Auth\RegisterUserRequest;
use App\Http\Requests\Auth\UserLoginRequest;
use App\Http\Resources\AuthResource;
use App\Services\AllergyService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Services\AuthService;
use Illuminate\Support\Facades\Auth;

class AuthController
{

    protected AuthService $auth_service;
    protected AllergyService $allergy_service;

    /**
     * Create a new controller instance.
     *
     * @param AuthService $auth_service
     * @param AllergyService $allergy_service
     */
    public function __construct(
        AuthService $auth_service,
        AllergyService $allergy_service
    )
    {
        $this->auth_service = $auth_service;
        $this->allergy_service = $allergy_service;
    }


    /**
     * Register a new user account
     *
     * @param RegisterUserRequest $request
     * @return JsonResponse
     */
    public function register(RegisterUserRequest $request): JsonResponse
    {
        $new_user = $this->auth_service->setupUserAccount($request->validated());
        $this->allergy_service->syncUserAllergies($new_user, $request->validated());
        return ApiResponse::send(
            Response::HTTP_CREATED,
                AuthResource::make($new_user),
                "New user account created successfully"
        );
    }


    /**
     * Register a new user account
     *
     * @param UserLoginRequest $request
     * @return JsonResponse
     */
    public function login(UserLoginRequest $request): JsonResponse
    {
        $login_attempt = $this->auth_service->login($request->validated());
        if ($login_attempt->is_successful){
            return ApiResponse::send(
                Response::HTTP_OK,
                AuthResource::make(Auth::user()),
                "Login successful"
            );
        }

        return ApiResponse::send(
            Response::HTTP_UNAUTHORIZED, [],
            "Invalid credentials. Email or Password incorrect"
        );
    }

    /**
     * Logout user by deleting tokens
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user()->tokens()->delete();
        return ApiResponse::send(Response::HTTP_OK, [], "Logout successful.");
    }

}
