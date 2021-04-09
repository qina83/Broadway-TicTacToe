<?php


namespace App\Identity\Application;

use App\Identity\Domain\Command\RegisterUserCommand;
use App\Identity\Domain\Model\User;
use App\Identity\Infrastructure\DBAL\EventSourcingUserRepository;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class RegisterUserCommandHandler implements MessageHandlerInterface
{
    private EventSourcingUserRepository $repository;

    /**
     * RegisterUserCommandHandler constructor.
     * @param EventSourcingUserRepository $repository
     */
    public function __construct(EventSourcingUserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(RegisterUserCommand $command): string
    {
        $nickname = $command->getPlayerNickName();

        $user = User::createUser($command->getPlayerNickName());
        $this->repository->save($user);
        $exUser = $this->repository->load($user->getAggregateRootId());
        return $exUser->getAggregateRootId();
    }
}