<?php

namespace App\Application\UseCases\Ad;

use App\Domain\Ad\Repositories\AdRepositoryInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class DeleteAd
{
    public function __construct(
        private AdRepositoryInterface $adRepository
    ) {}

    public function execute(int $adId, int $userId): void
    {
        $ad = $this->adRepository->findById($adId);

        if (!$ad) {
            throw new NotFoundHttpException('Ad not found');
        }

        if ($ad->user_id !== $userId) {
            throw new AccessDeniedHttpException('You are not the owner of this ad');
        }

        $this->adRepository->delete($adId);
    }
}
