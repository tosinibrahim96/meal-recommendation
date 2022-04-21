<?php


namespace App\Http\Controllers\Api;


use App\Http\ApiResponse;
use App\Http\Resources\AllergyResource;
use App\Repositories\AllergyRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AllergyController
{
    protected AllergyRepository $allergy_repository;

    /**
     * Create a new controller instance.
     *
     * @param AllergyRepository $allergy_repository
     */
    public function __construct(
        AllergyRepository $allergy_repository

    )
    {
        $this->allergy_repository =$allergy_repository;
    }

    /**
     * Retrieve all allergies from the database
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $allergies = $this->allergy_repository->getAll();
        return ApiResponse::send(
            Response::HTTP_OK,
            AllergyResource::collection($allergies),
            "Allergies retrieved successfully"
        );
    }

}
