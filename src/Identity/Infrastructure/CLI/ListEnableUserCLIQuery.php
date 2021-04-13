<?php


namespace App\Identity\Infrastructure\CLI;

use App\Identity\Domain\Command\DisableUserCommand;
use App\Identity\Domain\Command\RegisterUserCommand;
use App\Identity\Domain\Repository\EnableUserRepository;
use App\Identity\Domain\Repository\ExistingUserRepository;
use Broadway\ReadModel\Repository;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

class ListEnableUserCLIQuery extends Command
{
    protected static $defaultName = 'app:list-enable-users';
    private EnableUserRepository $repository;

    public function __construct(EnableUserRepository $repository)
    {
        parent::__construct();
        $this->repository = $repository;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $users = $this->repository->findAllEnableUsers();
        $output->writeln('Complete users list');
        $output->writeln('---------------------------------------');
        foreach ($users as $user){
            $output->write($user->getId());
            $output->write("\t".$user->getNickname());
            $output->writeln("");
        }
        $output->writeln('---------------------------------------');
        return Command::SUCCESS;
    }
}