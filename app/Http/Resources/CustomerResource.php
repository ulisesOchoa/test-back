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
     *     @OA\Property(property="date_of_joining", type="string", format="date", example="2024-08-16")
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
            'date_of_joining' => $this->date_of_joining
        ];
    }
}
