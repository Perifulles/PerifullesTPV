<?php

namespace Tests\Unit\User;

use App\Shared\Domain\Interfaces\AuditLoggerInterface;
use App\User\Application\CreateUser\CreateUser;
use App\User\Application\CreateUser\CreateUserResponse;
use App\User\Domain\Entity\User;
use App\User\Domain\Interfaces\PasswordHasherInterface;
use App\User\Domain\Interfaces\UserRepositoryInterface;
use Mockery;
use PHPUnit\Framework\TestCase;

class CreateUserTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_invoke_creates_user_saves_via_repository_and_returns_response(): void
    {
        $repository = Mockery::mock(UserRepositoryInterface::class);
        $passwordHasher = Mockery::mock(PasswordHasherInterface::class);
        $auditLogger = Mockery::mock(AuditLoggerInterface::class);
        $restaurantUuid = '11111111-1111-4111-8111-111111111111';

        $hashedPassword = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi';
        $passwordHasher->shouldReceive('hash')
            ->once()
            ->with('plain-password')
            ->andReturn($hashedPassword);

        $repository->shouldReceive('save')
            ->once()
            ->with(Mockery::on(function (User $user) use ($hashedPassword) {
                return $user->email()->value() === 'create@example.com'
                    && $user->name()->value() === 'Create User'
                    && $user->passwordHash()->value() === $hashedPassword;
            }));

        $auditLogger->shouldReceive('log')
            ->once()
            ->with(
                'user',
                Mockery::type('string'),
                'create',
                null,
                Mockery::on(function (array $newValues): bool {
                    return $newValues['name'] === 'Create User'
                        && $newValues['email'] === 'create@example.com'
                        && $newValues['role'] === 'admin';
                }),
                null,
                $restaurantUuid,
            );

        $createUser = new CreateUser($repository, $passwordHasher, $auditLogger);
        $response = $createUser($restaurantUuid, 'Create User', 'create@example.com', 'plain-password', 'admin');

        $this->assertInstanceOf(CreateUserResponse::class, $response);
        $this->assertSame('create@example.com', $response->email);
        $this->assertSame('Create User', $response->name);
        $this->assertSame('admin', $response->role);
        $this->assertMatchesRegularExpression(
            '/^[0-9a-f]{8}-[0-9a-f]{4}-4[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/i',
            $response->uuid
        );
        $array = $response->toArray();
        $this->assertArrayHasKey('created_at', $array);
        $this->assertArrayHasKey('updated_at', $array);
    }
}
