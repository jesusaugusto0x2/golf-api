<?php

namespace App\Application\UseCases\Ad;

use App\Domain\Ad\Models\Ad;
use App\Domain\Ad\Repositories\AdRepositoryInterface;

class CreateAd
{
    public function __construct(
        private AdRepositoryInterface $adRepository
    ) {}

    public function execute(array $data): Ad
    {
        return $this->adRepository->create($data);
    }
}
