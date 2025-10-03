<?php

namespace App\Infrastructure\Repositories;

use App\Domain\User\Models\User;
use App\Domain\User\Repositories\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;

class EloquentUserRepository implements UserRepositoryInterface
{
    public function create(array $data): User
    {
        return User::create([
            'name' => $data['name'],
            'surname' => $data['surname'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    public function findByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }
}
