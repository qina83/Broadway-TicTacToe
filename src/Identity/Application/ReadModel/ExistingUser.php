<?php


namespace App\Identity\Application\ReadModel;
use App\Identity\Domain\Model\User;

class ExistingUser
{
    private string $userId;
    private string $nickname;
    private bool $enable;

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

    /**
     * @return bool
     */
    public function isEnable(): bool
    {
        return $this->enable;
    }

    /**
     * @param bool $enable
     */
    public function setEnable(bool $enable): void
    {
        $this->enable = $enable;
    }

    public function getId(): string
    {
        return $this->userId;
    }
}