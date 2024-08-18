<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QualityResource extends JsonResource
{
    /**
     * @OA\Schema(
     *     schema="QualityResource",
     *     type="object",
     *     @OA\Property(property="id", type="integer", example=1),
     *     @OA\Property(property="name", type="string", example="A"),
     *     @OA\Property(property="price", type="number", format="float", example=100.00),
     *     @OA\Property(property="supplier_id", type="integer", example=1),
     *     @OA\Property(property="created_at", type="string", format="date-time", example="2024-08-16T12:00:00Z"),
     *     @OA\Property(property="updated_at", type="string", format="date-time", example="2024-08-16T12:00:00Z")
     * )
     * @param Request $request
     * @return array
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'price' => $this->price,
            'supplier_id' => $this->supplier_id,
            'company_name' => $this->supplier->company_name,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
