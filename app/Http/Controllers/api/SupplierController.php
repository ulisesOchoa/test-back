<?php

namespace App\Http\Controllers\api;

use App\Classes\ApiResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSupplierRequest;
use App\Http\Requests\UpdateSupplierRequest;
use App\Http\Resources\SupplierResource;
use App\Interfaces\SupplierRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

/**
 * @OA\Tag(
 *     name="Suppliers",
 *     description="Operations related to suppliers"
 * )
 */
class SupplierController extends Controller
{
    private SupplierRepositoryInterface $supplierRepository;

    public function __construct(SupplierRepositoryInterface $supplierRepository)
    {
        $this->supplierRepository = $supplierRepository;
    }

    /**
     * @OA\Get(
     *     path="/api/suppliers",
     *     summary="Get all suppliers",
     *     tags={"Suppliers"},
     *     @OA\Response(
     *         response=200,
     *         description="List of suppliers",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/SupplierResource")
     *         )
     *     )
     * )
     */
    public function index()
    {
        $data = $this->supplierRepository->getAll();

        return ApiResponseHelper::sendResponse(
            SupplierResource::collection($data),
            '',
            Response::HTTP_OK
        );
    }

    /**
     * @OA\Post(
     *     path="/api/suppliers",
     *     summary="Create a new Suppliers",
     *     tags={"Suppliers"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/StoreSupplierRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Suppliers created successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Record create successful")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="error", type="string", example="Validation error")
     *         )
     *     )
     * )
     */
    public function store(StoreSupplierRequest $request)
    {
        $data = $request->validated();

        DB::beginTransaction();
        try {
            $this->supplierRepository->create($data);
            DB::commit();

            return ApiResponseHelper::sendResponse(
                true,
                'Record create successful',
                Response::HTTP_CREATED
            );
        } catch (\Exception $e) {
            return ApiResponseHelper::rollBack($e);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/suppliers/{id}",
     *     summary="Retrieve a specific suppliers",
     *     tags={"Suppliers"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the suppliers to retrieve",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             example="123"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Suppliers retrieved successfully",
     *         @OA\JsonContent(
     *             ref="#/components/schemas/SupplierResource"
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Suppliers not found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="error", type="string", example="Sustomer not found")
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
            $supplier = $this->supplierRepository->getById($id);

            return ApiResponseHelper::sendResponse(
                new SupplierResource($supplier),
                '',
                Response::HTTP_OK
            );
        } catch (\Exception $e) {
            return ApiResponseHelper::throw($e, $e->getMessage());
        }
    }

    /**
     * @OA\Put(
     *     path="/api/suppliers/{id}",
     *     summary="Update a specific Suppliers",
     *     tags={"Suppliers"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the Suppliers to update",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             example="123"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             ref="#/components/schemas/UpdateSupplierRequest"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Suppliers updated successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Record updated successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Suppliers not found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="error", type="string", example="Suppliers not found")
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
    public function update(UpdateSupplierRequest $request, string $id)
    {
        $data = $request->validated();

        DB::beginTransaction();
        try {
            $this->supplierRepository->update($id, $data);
            DB::commit();

            return ApiResponseHelper::sendResponse(
                true,
                'Record updated successful',
                Response::HTTP_OK
            );
        } catch (\Exception $e) {
            return ApiResponseHelper::rollBack($e, $e->getMessage());
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/suppliers/{id}",
     *     summary="Delete a specific supplier",
     *     tags={"Suppliers"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the supplier to delete",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             example="123"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Supplier deleted successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Record deleted successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Supplier not found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="error", type="string", example="Supplier not found")
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
    public function destroy(string $id)
    {
        $this->supplierRepository->delete($id);

        return ApiResponseHelper::sendResponse(
            null,
            'Record deleted successful',
            Response::HTTP_OK
        );
    }
}
