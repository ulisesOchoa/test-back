<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCustomerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return false;
    }

    public function rules(): array
    {
        return [
            'id' => 'required|number',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'identity_number' => 'required|min:5|max:20',
            'date_of_joining' => 'required',
        ];
    }

    public function messages(): array {
        return [
            'id.required' => 'Customer is required',
            'first_name.required' => 'First name is required',
            'last_name.required' => 'Last name is required',
            'identity_number.required' => 'Identity number is required',
            'date_of_joining.required' => 'Date of joining is required',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new \HttpResponseException(response()->json([
            'success' => false,
            'message' => $validator->errors()->first(),
            'data' => $validator->errors()
        ]));
    }
}
