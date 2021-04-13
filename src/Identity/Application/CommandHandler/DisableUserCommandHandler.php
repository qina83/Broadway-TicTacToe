<?php


namespace App\Identity\Application\CommandHandler;

use App\Identity\Domain\Command\DisableUserCommand;
use App\Identity\Domain\Model\User;
use App\Identity\Domain\Repository\UserRepository;
use Broadway\Domain\AggregateRoot;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class DisableUserCommandHandler implements MessageHandlerInterface
{
    private UserRepository $repository;

    /**
     * @var User|AggregateRoot
     */
    private User $user;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(DisableUserCommand $command): void
    {
        $this->user = $this->repository->loadUser($command->getUserId());
        $this->user->Disable();
        $this->repository->saveUser( $this->user);
    }
}