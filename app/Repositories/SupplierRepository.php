<?php

namespace App\Repositories;

use App\Interfaces\SupplierRepositoryInterface;
use App\Models\Supplier;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class SupplierRepository implements SupplierRepositoryInterface
{
    public function getAll(): Collection
    {
        return Supplier::all();
    }

    public function getById(int $id): ?Supplier
    {
        return Supplier::findOrFail($id);
    }

    public function create(array $data): bool
    {
        $customer = Supplier::create($data);
        return (bool)$customer;
    }

    public function update(int $id, array $data) : bool
    {
        $customer = Supplier::findOrFail($id);

        return $customer->update($data);
    }

    public function delete(int $id): int
    {
        return Supplier::destroy($id);
    }
}
