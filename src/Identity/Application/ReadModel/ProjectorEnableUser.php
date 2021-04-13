<?php


namespace App\Identity\Application\ReadModel;

use App\Identity\Domain\Event\UserWasDisabled;
use App\Identity\Domain\Event\UserWasRegistered;
use App\Identity\Domain\Repository\EnableUserRepository;
use App\Identity\Domain\Repository\ExistingUserRepository;
use Broadway\ReadModel\Projector;
use Webmozart\Assert\Assert;

class ProjectorEnableUser extends Projector
{
    private EnableUserRepository $repository;

    public function __construct(EnableUserRepository $repository)
    {
        $this->repository = $repository;
    }

    protected function applyUserWasDisabled(UserWasDisabled $event)
    {
        $this->repository->removeEnableUser($event->getUserId());
    }

    protected function applyUserWasRegistered(UserWasRegistered $event)
    {
        $exUser = new EnableUser($event->getUserId(), $event->getNickname());
        $this->repository->saveEnableUser($exUser);
    }
}