<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Ad\Models\Ad;
use App\Domain\Ad\Repositories\AdRepositoryInterface;

class EloquentAdRepository implements AdRepositoryInterface
{
    public function create(array $data): Ad
    {
        return Ad::create($data);
    }
}
