<?php

namespace App\Repositories;

use App\Interfaces\QualityRepositoryInterface;
use App\Models\Quality;
use Illuminate\Database\Eloquent\Collection;

class QualityRepository implements QualityRepositoryInterface
{

    public function getAll(): Collection
    {
        return Quality::with('supplier')->get();
    }

    public function getById(int $id): ?Quality
    {
        return Quality::findOrFail($id);
    }
}
