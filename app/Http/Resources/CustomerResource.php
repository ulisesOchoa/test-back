<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
{
    /**
     * @OA\Schema(
     *     schema="CustomerResource",
     *     type="object",
     *     @OA\Property(property="id", type="integer", example=1),
     *     @OA\Property(property="first_name", type="string", example="John"),
     *     @OA\Property(property="last_name", type="string", example="Doe"),
     *     @OA\Property(property="identity_number", type="string", example="A12345678"),
     *     @OA\Property(property="date_of_joining", type="string", format="date", example="2024-08-16"),
     *     @OA\Property(property="purchase_price", type="number", format="float", example=100.00),
     *     @OA\Property(property="sale_price", type="number", format="float", example=150.00),
     *     @OA\Property(property="profit", type="number", format="float", example=50.00),
     *     @OA\Property(property="quality", type="string", example="A"),
     *     @OA\Property(property="supplier", type="string", example="Supplier Name")
     * )
     * @param Request $request
     * @return array
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'identity_number' => $this->identity_number,
            'date_of_joining' => $this->date_of_joining,
            'purchase_price' => $this->assignment->purchase_price ?? null,
            'sale_price' => $this->assignment->sale_price ?? null,
            'profit' => $this->assignment->profit ?? null,
            'quality_id' => $this->assignment->quality->id ?? null,
            'quality' => $this->assignment->quality->name ?? null,
            'supplier' => $this->assignment->quality->supplier->company_name ?? null,
        ];
    }
}
