<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\User;

interface UserRepositoryInterface
{
    /**
     * @param int $id
     * @return User|null
     */
    public function findById(int $id): ?User;

    /**
     * @param User $entity
     * @param bool $flush
     * @return void
     */
    public function save(User $entity, bool $flush = false): void;
}