<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface QualityRepositoryInterface
{
    public function getAll() : Collection;

    public function getById(int $id): ?Model;
}
