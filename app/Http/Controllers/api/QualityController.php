<?php

namespace App\Http\Controllers\api;

use App\Classes\ApiResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\QualityResource;
use App\Interfaces\QualityRepositoryInterface;
use Symfony\Component\HttpFoundation\Response;

class QualityController extends Controller
{
    private QualityRepositoryInterface $qualityRepository;

    public function __construct(QualityRepositoryInterface $qualityRepository)
    {
        $this->qualityRepository = $qualityRepository;
    }

    /**
     * @OA\Get(
     *     path="/api/qualities",
     *     summary="Get all qualities",
     *     tags={"Quality"},
     *     @OA\Response(
     *         response=200,
     *         description="List of qualities",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/QualityResource")
     *         )
     *     )
     * )
     */
    public function index()
    {
        $data = $this->qualityRepository->getAll();
        return ApiResponseHelper::sendResponse(
            QualityResource::collection($data),
            '',
            Response::HTTP_OK
        );
    }

    /**
     * @OA\Get(
     *     path="/api/qualities/{id}",
     *     summary="Retrieve a specific quality",
     *     tags={"Quality"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the quality to retrieve",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             example="123"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Quality retrieved successfully",
     *         @OA\JsonContent(
     *             ref="#/components/schemas/QualityResource"
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Quality not found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="error", type="string", example="Quality not found")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="error", type="string", example="An error occurred")
     *         )
     *     )
     * )
     */
    public function show(string $id)
    {
        try {
            $customer = $this->qualityRepository->getById($id);

            return ApiResponseHelper::sendResponse(
                new QualityResource($customer),
                '',
                Response::HTTP_OK
            );
        } catch (\Exception $e) {
            return ApiResponseHelper::throw($e, $e->getMessage());
        }
    }
}
