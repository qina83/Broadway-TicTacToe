<?php


namespace App\Identity\Infrastructure\DBAL;

use App\Identity\Application\ReadModel\ExistingUser;

class ExistingUserMapper
{
    public static function deserialize(array $data): ExistingUser
    {
        $rm = new ExistingUser($data["uuid"], $data["nickname"]);
        $rm->setEnable(boolval($data["enable"]));

        return $rm;
    }
}