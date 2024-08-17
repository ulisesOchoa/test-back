<?php

namespace App\Repositories;

use App\Interfaces\CustomerRepositoryInterface;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Collection;

class CustomerRepository implements CustomerRepositoryInterface
{

    public function getAll(): Collection
    {
        return Customer::all();
    }

    public function getById(int $id): ?Customer
    {
        return Customer::findOrFail($id);
    }

    public function create(array $data): bool
    {
        $customer = Customer::create($data);
        return (bool)$customer;
    }

    public function update(int $id, array $data) : bool
    {
        $customer = Customer::findOrFail($id);

        return $customer->update($data);
    }

    public function delete(int $id): int
    {
        return Customer::destroy($id);
    }
}
