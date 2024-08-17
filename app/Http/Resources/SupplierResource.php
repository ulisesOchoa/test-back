<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SupplierResource extends JsonResource
{

    /**
     * @OA\Schema(
     *     schema="SupplierResource",
     *     type="object",
     *     @OA\Property(property="id", type="integer", example=1),
     *     @OA\Property(property="company_name", type="string", example="ABC Corp"),
     *     @OA\Property(property="country", type="string", example="USA"),
     *     @OA\Property(property="cif", type="string", example="A12345678"),
     *     @OA\Property(property="registration_date", type="string", format="date", example="2024-08-17")
     * )
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'company_name' => $this->company_name,
            'country' => $this->country,
            'cif' => $this->cif,
            'registration_date' => $this->registration_date->toDateString(),
        ];
    }
}
