<?php

namespace App\Application\UseCases\Auth;

use App\Domain\User\Models\User;
use App\Domain\User\Repositories\UserRepositoryInterface;

class RegisterUser
{
    public function __construct(
        private UserRepositoryInterface $userRepository
    ) {}

    public function execute(array $data): User
    {
        $existingUser = $this->userRepository->findByEmail($data['email']);
        
        if ($existingUser) {
            throw new \Exception('Email already registered');
        }

        return $this->userRepository->create($data);
    }
}
