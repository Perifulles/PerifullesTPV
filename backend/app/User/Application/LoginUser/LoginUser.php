<?php

declare(strict_types=1);

namespace App\User\Application\LoginUser;

use App\Shared\Domain\ValueObject\Email;
use App\Shared\Domain\ValueObject\Uuid;
use App\User\Domain\Interfaces\PasswordHasherInterface;
use App\User\Domain\Interfaces\TokenGeneratorInterface;
use App\User\Domain\Interfaces\UserRepositoryInterface;

final class LoginUser
{
	public function __construct(
		private readonly UserRepositoryInterface $userRepository,
		private readonly PasswordHasherInterface $passwordHasher,
		private readonly TokenGeneratorInterface $tokenGenerator,
	) {}

	public function __invoke(string $email, string $password, string $restaurantId): LoginUserResponse
	{
		$emailVO = Email::create($email);
		$restaurantIdVO = Uuid::create($restaurantId);

		$user = $this->userRepository->findByEmail($emailVO, $restaurantIdVO);


		if ($user === null) {
			throw new \DomainException('Invalid credentials.');
		}

		if (!$this->passwordHasher->verify($password, $user->passwordHash()->value())) {
			throw new \DomainException('Invalid credentials.');
		}

		$token = $this->tokenGenerator->generate($user->uuid());

		return LoginUserResponse::create($user, $token);
	}
}

