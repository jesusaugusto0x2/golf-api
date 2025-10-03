<?php

namespace App\Domain\Ad\Repositories;

use App\Domain\Ad\Models\Ad;

interface AdRepositoryInterface
{
    public function create(array $data): Ad;
}
