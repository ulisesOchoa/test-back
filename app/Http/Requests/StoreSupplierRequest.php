<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;


/**
 * @OA\Schema(
 *     schema="StoreSupplierRequest",
 *     type="object",
 *     required={"company_name", "country", "cif", "registration_date"},
 *     @OA\Property(property="company_name", type="string", example="Tech Solutions"),
 *     @OA\Property(property="country", type="string", example="Spain"),
 *     @OA\Property(property="cif", type="string", example="A12345678"),
 *     @OA\Property(property="registration_date", type="string", format="date", example="2024-08-16")
 * )
 */
class StoreSupplierRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'company_name' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'cif' => 'required|string|max:255|unique:suppliers,cif',
            'registration_date' => 'required|date',
        ];
    }

    public function messages()
    {
        return [
            'company_name.required' => 'The company name field is required.',
            'company_name.string' => 'The company name must be a string.',
            'company_name.max' => 'The company name may not be greater than 255 characters.',

            'country.required' => 'The country field is required.',
            'country.string' => 'The country must be a string.',
            'country.max' => 'The country may not be greater than 255 characters.',

            'cif.required' => 'The CIF field is required.',
            'cif.string' => 'The CIF must be a string.',
            'cif.max' => 'The CIF may not be greater than 255 characters.',
            'cif.unique' => 'The CIF has already been taken.',

            'registration_date.required' => 'The registration date field is required.',
            'registration_date.date' => 'The registration date is not a valid date.',
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
