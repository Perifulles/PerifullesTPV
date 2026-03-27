<?php

declare(strict_types=1);

namespace App\User\Infrastructure\Persistence\Repositories;

use App\Shared\Domain\ValueObject\Email;
use App\Shared\Domain\ValueObject\Uuid;
use App\User\Domain\Entity\User;
use App\User\Domain\Interfaces\UserRepositoryInterface;
use App\User\Infrastructure\Persistence\Models\EloquentUser;
use App\Restaurant\Infrastructure\Persistence\Models\EloquentRestaurant;

final class EloquentUserRepository implements UserRepositoryInterface
{
    public function save(User $user): void
    {
        EloquentUser::create([
            'uuid' => $user->uuid()->value(),
            'restaurant_id' => $this->resolveRestaurantId($user->restaurantId()),
            'role' => $user->role()->value(),
            'image_src' => $user->imageSrc()->value(),
            'name' => $user->name()->value(),
            'email' => $user->email()->value(),
            'password' => $user->passwordHash()->value(),
            'pin' => $user->pin()->value(),
        ]);
    }

    public function findByUuid(Uuid $uuid): ?User
    {
        $model = EloquentUser::where('uuid', $uuid->value())->first();

        if ($model === null) {
            return null;
        }

        return $this->toDomainEntity($model);
    }

    public function findByEmail(Email $email, Uuid $restaurantId): ?User
    {
        $model = EloquentUser::where('email', $email->value())
            ->where('restaurant_id', $this->resolveRestaurantId($restaurantId))
            ->first();

        if ($model === null) {
            return null;
        }

        return $this->toDomainEntity($model);
    }

    public function findAllByRestaurant(Uuid $restaurantId): array
    {
        return EloquentUser::where('restaurant_id', $this->resolveRestaurantId($restaurantId))
            ->get()
            ->map(fn (EloquentUser $model) => $this->toDomainEntity($model))
            ->toArray();
    }

    public function update(User $user): void
    {
        EloquentUser::where('uuid', $user->uuid()->value())->update([
            'role' => $user->role()->value(),
            'image_src' => $user->imageSrc()->value(),
            'name' => $user->name()->value(),
            'email' => $user->email()->value(),
            'password' => $user->passwordHash()->value(),
            'pin' => $user->pin()->value(),
        ]);
    }

    public function delete(Uuid $uuid): void
    {
        EloquentUser::where('uuid', $uuid->value())->delete();
    }

    private function toDomainEntity(EloquentUser $model): User
    {
        $restaurantUuid = EloquentRestaurant::where('id', $model->restaurant_id)->value('uuid');

        return User::fromPrimitives(
            $model->uuid,
            $model->role,
            $model->image_src,
            $model->name,
            $model->email,
            $model->password,
            $model->pin,
            $restaurantUuid,
            $model->created_at->toDateTimeString(),
            $model->updated_at->toDateTimeString(),
        );
    }

    private function resolveRestaurantId(Uuid $restaurantUuid): int
    {
        $id = EloquentRestaurant::where('uuid', $restaurantUuid->value())->value('id');

        if ($id === null) {
            throw new \InvalidArgumentException('Restaurant not found for UUID: ' . $restaurantUuid->value());
        }

        return (int) $id;
    }
}