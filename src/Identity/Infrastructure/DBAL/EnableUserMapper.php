<?php


namespace App\Identity\Infrastructure\DBAL;

use App\Identity\Application\ReadModel\EnableUser;

class EnableUserMapper
{
    public static function deserialize(array $data): EnableUser
    {
        $rm = new EnableUser($data["uuid"], $data["nickname"]);
        return $rm;
    }
}