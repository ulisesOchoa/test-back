<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QualitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $qualities = [
            [
                'name' => 'A',
                'price' => 100.00,
                'supplier_id' => 1,
            ],
            [
                'name' => 'B',
                'price' => 150.00,
                'supplier_id' => 1,
            ],
            [
                'name' => 'C',
                'price' => 200.00,
                'supplier_id' => 2,
            ],
            [
                'name' => 'D',
                'price' => 250.00,
                'supplier_id' => 2,
            ],
        ];

        DB::table('qualities')->insert($qualities);
    }
}
