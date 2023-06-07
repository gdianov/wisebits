<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\User;
use App\Repository\UserRepositoryInterface;

class UserService
{
    /**
     * @var UserRepositoryInterface
     */
    private UserRepositoryInterface $repository;

    /**
     * @param UserRepositoryInterface $repository
     */
    public function __construct(
        UserRepositoryInterface $repository,
    ) {
        $this->repository = $repository;
    }

    /**
     * @param int $id
     * @return User|null
     */
    public function find(int $id): ?User
    {
        return $this->repository->find($id);
    }

    /**
     * @param User $user
     * @return void
     */
    public function save(User $user): void
    {
        $this->repository->save($user, true);
    }
}
