<?php

namespace App\Domain\Ad\Repositories;

use App\Domain\Ad\Models\Ad;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface AdRepositoryInterface
{
    public function create(array $data): Ad;

    public function list(array $params): Collection|LengthAwarePaginator;
}
