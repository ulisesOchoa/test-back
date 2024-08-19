<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

/**
 * @OA\Schema(
 *     schema="StoreCustomerRequest",
 *     type="object",
 *     required={
 *         "first_name",
 *         "last_name",
 *         "identity_number",
 *         "date_of_joining",
 *         "purchase_price",
 *         "sale_price",
 *         "profit",
 *         "quality_id",
 *         "supplier_id"
 *     },
 *     @OA\Property(property="first_name", type="string", example="John"),
 *     @OA\Property(property="last_name", type="string", example="Doe"),
 *     @OA\Property(property="identity_number", type="string", example="123456789"),
 *     @OA\Property(property="date_of_joining", type="string", format="date", example="2024-08-16"),
 *     @OA\Property(property="purchase_price", type="number", format="float", example=100.50),
 *     @OA\Property(property="sale_price", type="number", format="float", example=150.75),
 *     @OA\Property(property="profit", type="number", format="float", example=50.25),
 *     @OA\Property(property="quality_id", type="integer", example=1),
 * )
 */
class StoreCustomerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'identity_number' => 'required|min:5|max:20|unique:customers,identity_number',
            'date_of_joining' => 'required',
            'quality_id' => 'required',
            'purchase_price' => 'required',
            'sale_price' => 'required',
            'profit' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'first_name.required' => 'First name is required',
            'last_name.required' => 'Last name is required',
            'identity_number.required' => 'Identity number is required',
            'identify_number.unique' => 'Identity number already exists',
            'date_of_joining.required' => 'Date of joining is required',
            'purchase_price' => 'Purchase price is required',
            'sale_price' => 'Sale price is required',
            'profit' => 'Profit is required',
            'quality_id' => 'Quality is required',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => $validator->errors()->first(),
            'data' => $validator->errors()
        ], Response::HTTP_UNPROCESSABLE_ENTITY));
    }
}
