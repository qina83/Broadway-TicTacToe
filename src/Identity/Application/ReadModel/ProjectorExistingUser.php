<?php


namespace App\Identity\Application\ReadModel;

use App\Identity\Domain\Event\UserWasDisabled;
use App\Identity\Domain\Event\UserWasRegistered;
use App\Identity\Domain\Repository\ExistingUserRepository;
use Broadway\ReadModel\Projector;
use Webmozart\Assert\Assert;

class ProjectorExistingUser extends Projector
{
    private ExistingUserRepository $repository;

    public function __construct(ExistingUserRepository $repository)
    {
        $this->repository = $repository;
    }

    protected function applyUserWasDisabled(UserWasDisabled $event)
    {
        $exUser = $this->repository->findExitingUserById($event->getUserId());
        Assert::notNull($exUser);
        $exUser->setEnable(false);
        $this->repository->updateExistingUser($exUser);
    }

    protected function applyUserWasRegistered(UserWasRegistered $event)
    {
        $exUser = new ExistingUser($event->getUserId(), $event->getNickname());
        $this->repository->saveExistingUser($exUser);
    }
}