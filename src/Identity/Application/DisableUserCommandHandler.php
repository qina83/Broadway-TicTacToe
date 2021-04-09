<?php


namespace App\Identity\Application;

use App\Identity\Domain\Command\DisableUserCommand;
use App\Identity\Domain\Model\User;
use App\Identity\Infrastructure\DBAL\EventSourcingUserRepository;
use Broadway\Domain\AggregateRoot;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class DisableUserCommandHandler implements MessageHandlerInterface
{
    private EventSourcingUserRepository $repository;

    /**
     * @var User|AggregateRoot
     */
    private AggregateRoot $user;

    /**
     * RegisterUserCommandHandler constructor.
     * @param EventSourcingUserRepository $repository
     */
    public function __construct(EventSourcingUserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(DisableUserCommand $command): void
    {
        $this->user = $this->repository->load($command->getUserId());
        $this->user->Disable();
        $this->repository->save( $this->user);
    }
}