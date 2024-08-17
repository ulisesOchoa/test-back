<?php

namespace App\Http\Controllers\api;

use App\Classes\ApiResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Http\Resources\CustomerResource;
use App\Interfaces\CustomerRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class CustomerController extends Controller
{
    private CustomerRepositoryInterface $customerRepository;

    public function __construct(CustomerRepositoryInterface $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    public function index()
    {
        $data = $this->customerRepository->getAll();

        return ApiResponseHelper::sendResponse(
            CustomerResource::collection($data),
            '',
            Response::HTTP_OK
        );
    }

    public function store(StoreCustomerRequest $request)
    {
        $data = $request->validated();

        DB::beginTransaction();
        try {
            $this->customerRepository->create($data);
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

    public function destroy(string $id)
    {
        $this->customerRepository->delete($id);

        return ApiResponseHelper::sendResponse(
            null,
            'Record deleted successful',
            Response::HTTP_OK
        );
    }
}
