<?php

namespace App\Infrastructure\Services;

use App\Domain\User\Services\AuthTokenServiceInterface;
use Laravel\Sanctum\PersonalAccessToken;

final class SanctumTokenService implements AuthTokenServiceInterface
{
    public function revokeCurrentToken(int $userId, int $tokenId): void
    {
        PersonalAccessToken::query()
            ->where('id', $tokenId)
            ->where('tokenable_id', $userId)
            ->delete();
    }
}
