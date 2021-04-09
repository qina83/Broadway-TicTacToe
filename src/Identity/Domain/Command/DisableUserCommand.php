<?php


namespace App\Identity\Domain\Command;

use Ramsey\Uuid\UuidInterface;

namespace App\Identity\Domain\Command;
use Ramsey\Uuid\Rfc4122\UuidV4;
use Webmozart\Assert\Assert;

class DisableUserCommand
{
    private string $userId;

    /**
     * @return \Ramsey\Uuid\UuidInterface|string
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * RegisterUserCommand constructor.
     * @param UuidInterface $userId
     */
    public function __construct(string $userId)
    {
        Assert::notEmpty($userId, "user id must be not empty");
        $this->userId = UuidV4::fromString( $userId);
    }





}