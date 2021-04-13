<?php


namespace App\Identity\Application\CommandHandler;

use App\Identity\Domain\Command\RegisterUserCommand;
use App\Identity\Domain\Model\User;
use App\Identity\Domain\Repository\UserRepository;
use Broadway\Domain\AggregateRoot;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class RegisterUserCommandHandler implements MessageHandlerInterface
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

    public function __invoke(RegisterUserCommand $command): string
    {
        $nickname = $command->getPlayerNickName();

        $user = User::createUser($command->getPlayerNickName());
        $this->repository->saveUser($user);
        $exUser = $this->repository->loadUser($user->getAggregateRootId());
        return $exUser->getAggregateRootId();
    }
}