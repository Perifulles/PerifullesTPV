<?php

declare(strict_types=1);

namespace App\User\Application\LoginUser;

use App\User\Domain\Entity\User;

final readonly class LoginUserResponse
{
	public function __construct(
		public string $token,
		public string $id,
		public string $name,
		public string $email,
		public string $role,
		public string $restaurantId,
	) {}

	public static function create(User $user, string $token): self
	{
		return new self(
			token: $token,
			id: $user->uuid()->value(),
			name: $user->name()->value(),
			email: $user->email()->value(),
			role: $user->role()->value(),
			restaurantId: $user->restaurantId()->value(),
		);
	}

	/**
	 * @return array<string, string>
	 */
	public function toArray(): array
	{
		return [
			'token' => $this->token,
			'id' => $this->id,
			'name' => $this->name,
			'email' => $this->email,
			'role' => $this->role,
			'restaurant_id' => $this->restaurantId,
		];
	}
}

