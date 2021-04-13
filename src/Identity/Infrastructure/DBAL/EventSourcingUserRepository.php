<?php


namespace App\Identity\Infrastructure\DBAL;


use App\Identity\Domain\Model\User;
use App\Identity\Domain\Repository\UserRepository;
use Broadway\Domain\AggregateRoot;
use Broadway\EventHandling\EventBus;
use Broadway\EventSourcing\AggregateFactory\PublicConstructorAggregateFactory;
use Broadway\EventSourcing\EventSourcingRepository;
use Broadway\EventStore\EventStore;

class EventSourcingUserRepository extends EventSourcingRepository implements UserRepository
{
    public function __construct(
        EventStore $eventStore,
        EventBus $eventBus,
        array $eventStreamDecorators = []
    )
    {
        parent::__construct(
            $eventStore,
            $eventBus,
            User::class,
            new PublicConstructorAggregateFactory(),
            $eventStreamDecorators
        );
    }

    public function saveUser(User $user): void
    {
        $this->save($user);
    }

    /**
     * @param $id
     * @return User | AggregateRoot
     */
    public function loadUser($id): User
    {
        return $this->load($id);
    }
}