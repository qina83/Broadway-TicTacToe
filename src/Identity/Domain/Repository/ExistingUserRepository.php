<?php


namespace App\Identity\Domain\Repository;

use App\Identity\Application\ReadModel\ExistingUser;

interface ExistingUserRepository
{
    /**
     * @return ExistingUser[]
     */
    public function findAllExistingUsers(): array;

    public function findExitingUserById(string $id): ?ExistingUser;

    public function updateExistingUser(ExistingUser $exUSer): void;

    public function saveExistingUser(ExistingUser $exUSer): void;
}