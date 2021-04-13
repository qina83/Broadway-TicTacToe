<?php


namespace App\Identity\Domain\Repository;

use App\Identity\Domain\Model\User;

interface UserRepository
{
    public function saveUser(User $user): void;
    public function loadUser(string $id): User;
}