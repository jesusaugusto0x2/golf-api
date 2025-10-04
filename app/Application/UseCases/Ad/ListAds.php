<?php

namespace App\Application\UseCases\Ad;

use App\Domain\Ad\Repositories\AdRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class ListAds
{
    public function __construct(
        private AdRepositoryInterface $adRepository
    ) {}

    public function execute(array $params): Collection|LengthAwarePaginator
    {
        return $this->adRepository->list($params);
    }
}
