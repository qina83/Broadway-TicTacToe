<?php


namespace App\Identity\Domain\Command;

use Ramsey\Uuid\UuidInterface;

namespace App\Identity\Domain\Command;

use Webmozart\Assert\Assert;

class RegisterUserCommand
{
    private string $playerNickName;

    /**
     * RegisterUserCommand constructor.
     * @param string $playerNickName
     */
    public function __construct(string $playerNickName)
    {
        Assert::notEmpty($playerNickName, "Nickname must be not empty");
        $this->playerNickName = $playerNickName;
    }


    /**
     * @return string
     */
    public function getPlayerNickName(): string
    {
        return $this->playerNickName;
    }


}