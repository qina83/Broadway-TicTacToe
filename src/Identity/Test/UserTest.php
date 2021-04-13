<?php

namespace App\Identity\Test;

use App\Identity\Domain\Event\UserWasDisabled;
use App\Identity\Domain\Event\UserWasRegistered;
use App\Identity\Domain\Model\User;
use Broadway\EventSourcing\Testing\AggregateRootScenarioTestCase;
use Ramsey\Uuid\Rfc4122\UuidV4;


class UserTest extends AggregateRootScenarioTestCase
{

    protected function getAggregateRootClass(): string
    {
        return User::class;
    }

    public function test_can_register_user()
    {
        $id = UuidV4::uuid4();

        $this->scenario
            ->when(function () use ($id) {
                return User::createUserWithId($id,"nickname");
            })
            ->then([new UserWasRegistered($id, 'nickname')]);
    }

    public function test_can_disable_user()
    {
        $id = UuidV4::uuid4();

        $this->scenario
            ->withAggregateId($id)
            ->given([new UserWasRegistered($id, 'nickname')])
            ->when(function ($user) {
                $user->disable();
            })
            ->then([new UserWasDisabled($id)]);
    }
}
