<?php


namespace App\Identity\Domain\Event;


use Broadway\Serializer\Serializable;
use Ramsey\Uuid\Rfc4122\UuidV4;
use Ramsey\Uuid\UuidInterface;

class UserWasRegistered implements Serializable
{
    private UuidInterface $userId;
    private string $nickname;

    /**
     * @return UuidInterface
     */
    public function getUserId(): UuidInterface
    {
        return $this->userId;
    }

    /**
     * @return string
     */
    public function getNickname(): string
    {
        return $this->nickname;
    }

    /**
     * UserWasRegistered constructor.
     * @param UuidInterface $userId
     * @param string $nickname
     */
    public function __construct(UuidInterface $userId, string $nickname)
    {
        $this->userId = $userId;
        $this->nickname = $nickname;
    }

    public static function deserialize(array $data): UserWasRegistered
    {
        return new self(
            UuidV4::fromString($data['userId']),
            $data['nickname']
        );
    }

    public function serialize(): array
    {
        return [
            'userId' => $this->userId->toString(),
            'nickname' => $this->nickname
        ];
    }
}