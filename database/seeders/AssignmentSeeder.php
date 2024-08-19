<?php

namespace Database\Seeders;

use App\Models\Assignment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AssignmentSeeder extends Seeder
{

    public function run(): void
    {
        Assignment::create([
            'customer_id' => 1,
            'quality_id' => 1,
            'purchase_price' => 100.00,
            'sale_price' => 150.00,
            'profit' => 50.00,
        ]);

        Assignment::create([
            'customer_id' => 2,
            'quality_id' => 2,
            'purchase_price' => 120.00,
            'sale_price' => 170.00,
            'profit' => 50.00,
        ]);
    }
}
