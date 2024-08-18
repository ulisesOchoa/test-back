<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $suppliers = [
            [
                'company_name' => 'GasSupplies Inc.',
                'country' => 'Spain',
                'cif' => Str::random(9),
                'registration_date' => now(),
            ],
            [
                'company_name' => 'Energy Solutions Ltd.',
                'country' => 'Germany',
                'cif' => Str::random(9),
                'registration_date' => now(),
            ],
            [
                'company_name' => 'Green Gas Providers',
                'country' => 'France',
                'cif' => Str::random(9),
                'registration_date' => now(),
            ],
        ];

        DB::table('suppliers')->insert($suppliers);
    }
}
