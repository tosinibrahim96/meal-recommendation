<?php


namespace App\Http\Controllers\Api;


use App\Http\ApiResponse;
use App\Http\Requests\MealRequests\CreateMealRequest;
use App\Http\Requests\MealRequests\DeleteMealRequest;
use App\Http\Requests\MealRequests\GetOneMealRequest;
use App\Http\Requests\MealRequests\UpdateMealRequest;
use App\Http\Resources\MealResource;
use App\Repositories\MealRepository;
use App\Services\MealService;
use App\Services\AllergyService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MealController
{

    protected MealService $meal_service;
    protected AllergyService $allergies_service;
    protected MealRepository $meal_repository;

    /**
     * Create a new controller instance.
     *
     * @param MealService $meal_service
     * @param AllergyService $allergies_service
     * @param MealRepository $meal_repository
     */
    public function __construct(
        MealService $meal_service,
        AllergyService $allergies_service,
        MealRepository $meal_repository

    )
    {
        $this->meal_service = $meal_service;
        $this->allergies_service = $allergies_service;
        $this->meal_repository = $meal_repository;
    }


    /**
     * Store a new meal in the database
     *
     * @param CreateMealRequest $request
     * @return JsonResponse
     */
    public function store(CreateMealRequest $request): JsonResponse
    {
        $new_meal = $this->meal_service->create($request->validated());
        $this->meal_service->syncMealItems($new_meal,$request->validated());
        $this->allergies_service->syncMealAllergies($new_meal, $request->validated());
        $message = $new_meal->items()->count() ?
            "New meal created successfully":
            "New meal created successfully. This meal will not be displayed in user recommendations since it does not contain main and side items.";
        return ApiResponse::send(
            Response::HTTP_CREATED,
            MealResource::make($new_meal),
            $message
        );
    }

    /**
     * Update meal details in the database
     *
     * @param UpdateMealRequest $request
     * @return JsonResponse
     */
    public function update(UpdateMealRequest $request): JsonResponse
    {
        $meal = $this->meal_service->update($request->validated());
        $this->meal_service->syncMealItems($meal,$request->validated());
        $this->allergies_service->syncMealAllergies($meal, $request->validated());
        $message = $meal->items()->count() ?
            "Meal details updated successfully":
            "Meal details updated successfully. This meal will not be displayed in user recommendations since it does not contain main and side items.";
        return ApiResponse::send(
            Response::HTTP_OK,
            MealResource::make($meal),
            $message
        );
    }

    /**
     * Retrieve a single meal from the database
     *
     * @param GetOneMealRequest $request
     * @return JsonResponse
     */
    public function show(GetOneMealRequest $request): JsonResponse
    {
        $meal = $this->meal_repository->getOne(
            $request->validated()['meal']
        );
        $message = $meal->items()->count() ?
            "Meal retrieved successfully":
            "Meal retrieved successfully. This meal will not be displayed in user recommendations since it does not contain main and side items.";
        return ApiResponse::send(
            Response::HTTP_OK,
            MealResource::make($meal),
            $message
        );
    }

    /**
     * Retrieve all meal from the database
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $meal_items = $this->meal_repository->getAll();
        return ApiResponse::send(
            Response::HTTP_OK,
            MealResource::collection($meal_items)->response()->getData(true),
            "Meals retrieved successfully"
        );
    }

    /**
     * Delete a meal from the database
     *
     * @param DeleteMealRequest $request
     * @return JsonResponse
     */
    public function destroy(DeleteMealRequest $request): JsonResponse
    {
        $this->meal_service->delete(
            $request->validated()['meal']
        );
        return ApiResponse::send(
            Response::HTTP_OK,
            [],
            "Meal deleted successfully"
        );
    }

}
