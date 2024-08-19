<?php

namespace App\Imports;

use App\Models\Customer;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class CustomerImport implements ToModel, WithHeadingRow, WithValidation
{

    public function model(array $row)
    {
        return new Customer([
            'first_name' => $row['first_name'],
            'last_name' => $row['last_name'],
            'identity_number' => $row['identity_number'],
            'date_of_joining' => $row['date_of_joining'],
        ]);
    }

    public function rules(): array
    {
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'identity_number' => 'required|string|max:20|unique:customers,identity_number',
            'date_of_joining' => 'required|date_format:Y-m-d',
        ];
    }
}
