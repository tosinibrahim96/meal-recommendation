<?php


namespace App\Http\Controllers\Api;


use App\Http\ApiResponse;
use App\Http\Requests\MealRecommendations\GetRecommendationsForManyRequest;
use App\Http\Requests\MealRecommendations\GetRecommendationsForOneRequest;
use App\Http\Resources\MealRecommendationResource;
use App\Http\Resources\MealResource;
use App\Models\User;
use App\Repositories\UserProfileRepository;
use App\Services\AllergyService;
use App\Services\MealService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MealRecommendationController
{

    protected UserProfileRepository $user_repository;

    /**
     * Create a new controller instance.
     *
     * @param UserProfileRepository $user_repository
     */
    public function __construct(
        UserProfileRepository $user_repository

    )
    {
        $this->user_repository = $user_repository;
    }

    /**
     * Get meal recommendations for a single user
     *
     * @param GetRecommendationsForOneRequest $request
     * @return JsonResponse
     */
    public function recommendForOne(GetRecommendationsForOneRequest $request): JsonResponse
    {
        return ApiResponse::send(
            Response::HTTP_OK,
            MealRecommendationResource::make(
                $this->user_repository->getOne($request->validated()['user'])
            ),
            "Meal recommendations retrieved successfully"
        );
    }

    /**
     * Get meal recommendations for all the users
     * specified in the request
     *
     * @param GetRecommendationsForManyRequest $request
     * @return JsonResponse
     */
    public function recommendForMany(GetRecommendationsForManyRequest $request): JsonResponse
    {
        return ApiResponse::send(
            Response::HTTP_OK,
            MealRecommendationResource::collection(
                $this->user_repository->getMany($request->validated()['users'])
            ),
            "Meal recommendations retrieved successfully"
        );
    }



}
