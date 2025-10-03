<?php

namespace App\Domain\User\Services;

interface AuthTokenServiceInterface
{
    public function revokeCurrentToken(int $userId, int $tokenId): void;
}
