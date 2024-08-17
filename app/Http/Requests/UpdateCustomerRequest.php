<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

/**
 * @OA\Schema(
 *     schema="UpdateCustomerRequest",
 *     type="object",
 *     title="Update Customer Request",
 *     description="Request body data for updating a customer",
 *     required={"first_name", "last_name", "identity_number", "date_of_joining"},
 *     @OA\Property(
 *         property="first_name",
 *         type="string",
 *         description="First name of the customer",
 *         example="John"
 *     ),
 *     @OA\Property(
 *         property="last_name",
 *         type="string",
 *         description="Last name of the customer",
 *         example="Doe"
 *     ),
 *     @OA\Property(
 *         property="date_of_joining",
 *         type="string",
 *         format="date",
 *         description="Date when the customer joined",
 *         example="2023-01-15"
 *     )
 * )
 */
class UpdateCustomerRequest extends FormRequest
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
            'date_of_joining' => 'required|date',
        ];
    }

    public function messages(): array {
        return [
            'first_name.required' => 'First name is required',
            'last_name.required' => 'Last name is required',
            'date_of_joining.required' => 'Date of joining is required',
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
