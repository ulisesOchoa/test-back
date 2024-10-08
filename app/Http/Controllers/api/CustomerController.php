<?php

namespace App\Http\Controllers\api;

use App\Classes\ApiResponseHelper;
use App\Exports\CustomerExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Http\Resources\CustomerResource;
use App\Interfaces\CustomerRepositoryInterface;
use App\Models\Assignment;
use App\Models\Quality;
use App\Models\Supplier;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\Response;

/**
 * @OA\Info(
 *     title="API TEST",
 *     version="1.0",
 *     description="This is a Api test"
 * )
 * @OA\Server(url="Http://localhost:8080")
 */
class CustomerController extends Controller
{
    private CustomerRepositoryInterface $customerRepository;

    public function __construct(CustomerRepositoryInterface $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    /**
     * @OA\Get(
     *     path="/api/customers",
     *     summary="Get all customers",
     *     tags={"Customer"},
     *     @OA\Response(
     *         response=200,
     *         description="List of customers",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/CustomerResource")
     *         )
     *     )
     * )
     */
    public function index()
    {
        $data = $this->customerRepository->getAll();

        return ApiResponseHelper::sendResponse(
            CustomerResource::collection($data),
            '',
            Response::HTTP_OK
        );
    }

    /**
     * @OA\Post(
     *     path="/api/customers",
     *     summary="Create a new customer",
     *     tags={"Customer"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/StoreCustomerRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Customer created successfully",
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
    public function store(StoreCustomerRequest $request)
    {
        $data = $request->validated();

        DB::beginTransaction();
        try {
            $customer = [
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'identity_number' => $data['identity_number'],
                'date_of_joining' => $data['date_of_joining'],
            ];
            $customerId = $this->customerRepository->create($customer);

            Assignment::create([
                'customer_id' => $customerId,
                'quality_id' => $data['quality_id'],
                'purchase_price' => $data['purchase_price'],
                'sale_price' => $data['sale_price'],
                'profit' => $data['profit'],
            ]);

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
     *     path="/api/customers/{id}",
     *     summary="Retrieve a specific customer",
     *     tags={"Customer"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the customer to retrieve",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             example="123"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Customer retrieved successfully",
     *         @OA\JsonContent(
     *             ref="#/components/schemas/CustomerResource"
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Customer not found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="error", type="string", example="Customer not found")
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
            $customer = $this->customerRepository->getById($id);

            return ApiResponseHelper::sendResponse(
                new CustomerResource($customer),
                '',
                Response::HTTP_OK
            );
        } catch (\Exception $e) {
            return ApiResponseHelper::throw($e, $e->getMessage());
        }
    }

    /**
     * @OA\Put(
     *     path="/api/customers/{id}",
     *     summary="Update a specific customer",
     *     tags={"Customer"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the customer to update",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             example="123"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             ref="#/components/schemas/UpdateCustomerRequest"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Customer updated successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Record updated successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Customer not found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="error", type="string", example="Customer not found")
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
    public function update(UpdateCustomerRequest $request, string $id)
    {
        $data = $request->validated();

        DB::beginTransaction();
        try {
            $this->customerRepository->update($id, $data);
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
     *     path="/api/customers/{id}",
     *     summary="Delete a specific customer",
     *     tags={"Customer"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the customer to delete",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             example="123"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Customer deleted successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Record deleted successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Customer not found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="error", type="string", example="Customer not found")
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
        $this->customerRepository->delete($id);

        return ApiResponseHelper::sendResponse(
            null,
            'Record deleted successful',
            Response::HTTP_OK
        );
    }

    /**
     * @OA\Get(
     *     path="/customers/export",
     *     summary="Exporta los datos de clientes a un archivo Excel",
     *     tags={"Customer"},
     *     @OA\Response(
     *         response=200,
     *         description="Archivo Excel con los datos de clientes exportado correctamente",
     *         @OA\MediaType(
     *             mediaType="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
     *             @OA\Schema(
     *                 type="string",
     *                 format="binary"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error al exportar el archivo"
     *     )
     * )
     */
    public function export()
    {
        return Excel::download(new CustomerExport, 'customers.xlsx');
    }

    /**
     * Este enpoin en unsistema real
     * estaria en el servicio back for front
     * si se v a utilizar el pratrón BFF
     * por eso no l odecoumento a swager
     * @return JsonResponse
     */
    public function initForm()
    {
        return response()->json([
            'qualities' => Quality::select(['id as value', 'name as label'])->get(),
//            'suppliers' => Supplier::select(['id as value', 'company_name as label'])->get(),
        ]);
    }
}
