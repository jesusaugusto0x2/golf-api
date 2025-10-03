<?php

namespace App\Application\UseCases\Auth;

use App\Domain\User\Services\AuthTokenServiceInterface;

final class LogoutUser
{
    public function __construct(private AuthTokenServiceInterface $tokenService) {}

    public function fromCurrentToken(int $userId, int $tokenId): void
    {
        $this->tokenService->revokeCurrentToken($userId, $tokenId);
    }
}
