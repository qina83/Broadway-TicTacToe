<?php


namespace App\Identity\Application\ReadModel;
use App\Identity\Domain\Model\User;

class EnableUser
{
    private string $userId;
    private string $nickname;

    /**
     * ExistingUser constructor.
     * @param string $userId
     * @param string $nickname
     */
    public function __construct(string $userId, string $nickname)
    {
        $this->userId = $userId;
        $this->nickname = $nickname;
    }

    /**
     * @return string
     */
    public function getNickname(): string
    {
        return $this->nickname;
    }

    /**
     * @param string $nickname
     */
    public function setNickname(string $nickname): void
    {
        $this->nickname = $nickname;
    }

    public function getId(): string
    {
        return $this->userId;
    }
}