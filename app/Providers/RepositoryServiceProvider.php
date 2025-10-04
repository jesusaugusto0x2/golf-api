<?php

namespace App\Providers;


use Illuminate\Support\ServiceProvider;

use App\Domain\User\Repositories\UserRepositoryInterface;
use App\Infrastructure\Repositories\EloquentUserRepository;

use App\Domain\User\Services\AuthTokenServiceInterface;
use App\Infrastructure\Services\SanctumTokenService;

use App\Domain\Ad\Repositories\AdRepositoryInterface;
use App\Infrastructure\Repositories\EloquentAdRepository;

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

        $this->app->bind(
            AdRepositoryInterface::class,
            EloquentAdRepository::class,
        );
    }

    public function boot(): void
    {
        //
    }
}
