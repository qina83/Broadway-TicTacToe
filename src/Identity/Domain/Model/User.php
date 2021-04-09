<?php


namespace App\Identity\Domain\Model;


use App\Identity\Domain\Event\UserWasDisabled;
use App\Identity\Domain\Event\UserWasRegistered;
use Broadway\EventSourcing\EventSourcedAggregateRoot;
use Ramsey\Uuid\Rfc4122\UuidV4;
use Ramsey\Uuid\UuidInterface;

class User extends EventSourcedAggregateRoot
{
    private UuidInterface $id;
    private string $nickname;
    private bool $disabled;

    public function getAggregateRootId(): string
    {
        return $this->id;
    }

    public static function createUser(string $nickname): User
    {
        $user = new User();
        $user->init(UuidV4::uuid4(), $nickname);
        return $user;
    }

    private function init(UuidInterface $id, string $nickname){
        $this->disabled = false;
        $this->id = $id;
        $this->nickname = $nickname;

        $this->apply(
            new UserWasRegistered( $this->id, $this->nickname)
        );
    }

    protected function applyUserWasRegistered(UserWasRegistered $event): void
    {
        $this->id = $event->getUserId();
        $this->nickname = $event->getNickname();
    }

    protected function applyUserWasDisabled(UserWasDisabled $event): void{
        $this->disabled = true;
    }


    public function Disable(){
        $this->apply(
            new UserWasDisabled($this->id)
        );
    }

}