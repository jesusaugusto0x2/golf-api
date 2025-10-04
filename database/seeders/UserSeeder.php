<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Domain\User\Models\User;

class UserSeeder extends Seeder
{
    private const USERS = [
        [
            'name' => 'Demo',
            'surname' => 'User',
            'email' => 'demo@example.com',
            'password' => 'password123',
        ],
        [
            'name' => 'John',
            'surname' => 'Doe',
            'email' => 'john@example.com',
            'password' => 'password123',
        ],
        [
            'name' => 'Jane',
            'surname' => 'Doe',
            'email' => 'jane@example.com',
            'password' => 'password123',
        ],
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (self::USERS as $data) {
            User::updateOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'surname' => $data['surname'],
                    'password' => Hash::make($data['password']),
                ]
            );
        }
    }
}
