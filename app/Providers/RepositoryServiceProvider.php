<?php

namespace App\Providers;

use App\Domain\User\Repositories\UserRepositoryInterface;
use App\Infrastructure\Repositories\EloquentUserRepository;
use Illuminate\Support\ServiceProvider;
use App\Domain\User\Services\AuthTokenServiceInterface;
use App\Infrastructure\Services\SanctumTokenService;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            UserRepositoryInterface::class,
            EloquentUserRepository::class,
        );

        $this->app->bind(
            AuthTokenServiceInterface::class,
            SanctumTokenService::class,
        );
    }

    public function boot(): void
    {
        //
    }
}
