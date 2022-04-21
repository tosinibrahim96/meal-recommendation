<?php


namespace App\Http\Controllers\Api;


use App\Http\ApiResponse;
use App\Http\Requests\UserProfileRequests\GetUserProfileRequest;
use App\Http\Requests\UserProfileRequests\UpdateUserProfileRequest;
use App\Http\Resources\UserProfileResource;
use App\Repositories\UserProfileRepository;
use App\Services\AllergyService;
use App\Services\UserProfileService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;


class UserProfileController
{
    protected UserProfileService $userprofile_service;
    protected AllergyService $allergy_service;
    protected UserProfileRepository $userprofile_repository;

    /**
     * Create a new controller instance.
     *
     * @param UserProfileService $userprofile_service
     * @param AllergyService $allergy_service
     * @param UserProfileRepository $userprofile_repository
     */
    public function __construct(
        UserProfileService $userprofile_service,
        AllergyService $allergy_service,
        UserProfileRepository $userprofile_repository
    )
    {
        $this->userprofile_service = $userprofile_service;
        $this->allergy_service = $allergy_service;
        $this->userprofile_repository = $userprofile_repository;
    }


    /**
     * Update the user's profile with new details
     *
     * @param UpdateUserProfileRequest $request
     * @return JsonResponse
     */
    public function update(UpdateUserProfileRequest $request): JsonResponse
    {
        $user = $this->userprofile_service->update($request->validated());
        $this->allergy_service->syncUserAllergies($user, $request->validated());
        return ApiResponse::send(
            Response::HTTP_OK,
            UserProfileResource::make($user),
            "User profile updated successfully"
        );
    }

    /**
     * Retrieve a single user profile from the database
     *
     * @param GetUserProfileRequest $request
     * @return JsonResponse
     */
    public function show(GetUserProfileRequest $request): JsonResponse
    {
        $user = $this->userprofile_repository->getOne(
            $request->validated()['user']
        );
        return ApiResponse::send(
            Response::HTTP_OK,
            UserProfileResource::make($user),
            "User profile retrieved successfully"
        );
    }

}
