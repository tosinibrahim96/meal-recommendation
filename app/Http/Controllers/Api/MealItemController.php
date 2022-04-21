<?php


namespace App\Http\Controllers\Api;


use App\Http\ApiResponse;
use App\Http\Requests\MealItemRequests\CreateMealItemRequest;
use App\Http\Requests\MealItemRequests\DeleteMealItemRequest;
use App\Http\Requests\MealItemRequests\GetOneMealItemRequest;
use App\Http\Requests\MealItemRequests\UpdateMealItemRequest;
use App\Http\Resources\MealItemResource;
use App\Repositories\MealItemRepository;
use App\Services\MealItemService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class MealItemController
{

    protected MealItemService $mealitem_service;
    protected MealItemRepository $mealitem_repository;

    /**
     * Create a new controller instance.
     *
     * @param MealItemService $mealitem_service
     * @param MealItemRepository $mealitem_repository
     */
    public function __construct(
        MealItemService $mealitem_service,
        MealItemRepository $mealitem_repository
    )
    {
        $this->mealitem_service = $mealitem_service;
        $this->mealitem_repository = $mealitem_repository;
    }


    /**
     * Store a new meal item in the database
     *
     * @param CreateMealItemRequest $request
     * @return JsonResponse
     */
    public function store(CreateMealItemRequest $request): JsonResponse
    {
        $new_mealitem = $this->mealitem_service->create($request->validated());
        return ApiResponse::send(
            Response::HTTP_CREATED,
            MealItemResource::make($new_mealitem),
            "New meal item created successfully"
        );

    }

    /**
     * Update details of an existing meal item in the database
     *
     * @param UpdateMealItemRequest $request
     * @return JsonResponse
     */
    public function update(UpdateMealItemRequest $request): JsonResponse
    {
        $meal_item = $this->mealitem_service->update($request->validated());
        return ApiResponse::send(
            Response::HTTP_OK,
            MealItemResource::make($meal_item),
            "Meal item details updated successfully"
        );
    }

    /**
     * Retrieve a single meal item from the database
     *
     * @param GetOneMealItemRequest $request
     * @return JsonResponse
     */
    public function show(GetOneMealItemRequest $request): JsonResponse
    {
        $meal_item = $this->mealitem_repository->getOne(
            $request->validated()['meal_item']
        );
        return ApiResponse::send(
            Response::HTTP_OK,
            MealItemResource::make($meal_item),
            "Meal item retrieved successfully"
        );
    }

    /**
     * Retrieve all meal items from the database
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $meal_items = $this->mealitem_repository->getAll();
        return ApiResponse::send(
            Response::HTTP_OK,
            MealItemResource::collection($meal_items)->response()->getData(true),
            "Meal items retrieved successfully"
        );
    }

    /**
     * Delete a meal item from the database
     *
     * @param DeleteMealItemRequest $request
     * @return JsonResponse
     */
    public function destroy(DeleteMealItemRequest $request): JsonResponse
    {
        $this->mealitem_service->delete(
            $request->validated()['meal_item']
        );
        return ApiResponse::send(
            Response::HTTP_OK,
            [],
            "Meal item deleted successfully"
        );
    }
}
