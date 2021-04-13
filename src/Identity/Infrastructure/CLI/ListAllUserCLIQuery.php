<?php


namespace App\Identity\Infrastructure\CLI;

use App\Identity\Domain\Command\DisableUserCommand;
use App\Identity\Domain\Command\RegisterUserCommand;
use App\Identity\Domain\Repository\ExistingUserRepository;
use Broadway\ReadModel\Repository;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

class ListAllUserCLIQuery extends Command
{
    protected static $defaultName = 'app:list-users';
    private ExistingUserRepository $repository;

    public function __construct(ExistingUserRepository $repository)
    {
        parent::__construct();
        $this->repository = $repository;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $users = $this->repository->findAllExistingUsers();
        $output->writeln('Complete users list');
        $output->writeln('---------------------------------------');
        foreach ($users as $user){
            $output->write($user->getId());
            $output->write("\t".$user->getNickname());
            $output->write("\t".$user->isEnable());
            $output->writeln("");
        }
        $output->writeln('---------------------------------------');
        return Command::SUCCESS;
    }
}