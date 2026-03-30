<?php

declare(strict_types=1);

namespace App\Providers;

use App\Shared\Domain\Interfaces\AuditLoggerInterface;
use App\Shared\Infrastructure\Services\EloquentAuditLogger;
use App\User\Domain\Interfaces\PasswordHasherInterface;
use App\User\Domain\Interfaces\TokenGeneratorInterface;
use App\User\Domain\Interfaces\UserRepositoryInterface;
use App\User\Infrastructure\Persistence\Repositories\EloquentUserRepository;
use App\User\Infrastructure\Services\LaravelPasswordHasher;
use App\User\Infrastructure\Services\SanctumTokenGenerator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(AuditLoggerInterface::class, EloquentAuditLogger::class);
        $this->app->bind(UserRepositoryInterface::class, EloquentUserRepository::class);
        $this->app->bind(PasswordHasherInterface::class, LaravelPasswordHasher::class);
        $this->app->bind(TokenGeneratorInterface::class, SanctumTokenGenerator::class);
    }

    public function boot(): void
    {
        //
    }
}