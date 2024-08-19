<?php

namespace App\Exports;

use App\Models\Customer;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CustomerExport implements FromCollection, WithHeadings
{

    public function collection()
    {
        return Customer::with(['assignment.quality'])->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'First Name',
            'Last Name',
            'Identity Number',
            'Date of Joining',
            'Purchase Price',
            'Sale Price',
            'Profit',
            'Quality Name',
            'Quality Price',
            'Supplier ID',
        ];
    }

    public function map($customer): array
    {
        return [
            $customer->id,
            $customer->first_name,
            $customer->last_name,
            $customer->identity_number,
            $customer->date_of_joining,
            $customer->assignment->purchase_price ?? '',
            $customer->assignment->sale_price ?? '',
            $customer->assignment->profit ?? '',
            $customer->assignment->quality->name ?? '',
            $customer->assignment->quality->price ?? '',
            $customer->assignment->quality->supplier_id ?? '',
        ];
    }
}
