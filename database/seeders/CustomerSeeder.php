<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        $customers = [
            [
                'first_name' => 'John',
                'last_name' => 'Doe',
                'identity_number' => 'ID123456789',
                'date_of_joining' => now(),
            ],
            [
                'first_name' => 'Jane',
                'last_name' => 'Smith',
                'identity_number' => 'ID987654321',
                'date_of_joining' => now(),
            ]
        ];

        DB::table('customers')->insert($customers);
    }
}
