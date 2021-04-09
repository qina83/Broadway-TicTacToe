<?php


namespace App\Identity\Domain\Event;


use Broadway\Serializer\Serializable;
use Ramsey\Uuid\Rfc4122\UuidV4;
use Ramsey\Uuid\UuidInterface;

class UserWasDisabled  implements Serializable
{
    private UuidInterface $userId;

    /**
     * UserWasDisabled constructor.
     * @param UuidInterface $userId
     */
    public function __construct(UuidInterface $userId)
    {
        $this->userId = $userId;
    }

    /**
     * @return UuidInterface
     */
    public function getUserId(): UuidInterface
    {
        return $this->userId;
    }

    public static function deserialize(array $data): UserWasDisabled
    {
        return new self(
            UuidV4::fromString($data['userId'])
        );
    }

    public function serialize(): array
    {
        return [
            'userId' => $this->userId->toString()
        ];
    }
}