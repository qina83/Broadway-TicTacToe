<?php


namespace App\Identity\Domain\Repository;

use App\Identity\Application\ReadModel\EnableUser;

interface EnableUserRepository
{
    /**
     * @return EnableUser[]
     */
    public function findAllEnableUsers(): array;

    public function findEnableUserById(string $id): ?EnableUser;

    public function updateEnableUser(EnableUser $enUser): void;

    public function removeEnableUser(string $id): void;

    public function saveEnableUser(EnableUser $enUser): void;
}