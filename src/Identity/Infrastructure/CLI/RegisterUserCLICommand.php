<?php


namespace App\Identity\Infrastructure\CLI;

use App\Identity\Domain\Command\RegisterUserCommand;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

class RegisterUserCLICommand extends Command
{
    private MessageBusInterface $bus;

    public function __construct(MessageBusInterface $bus)
    {
        parent::__construct();

        $this->bus = $bus;
    }

    protected function configure()
    {
        parent::configure();
        $this
            ->setName('app:register-user')
            // the short description shown while running "php bin/console list"
            ->setDescription('Creates a new user')

            // the full command description shown when running the command with
            // the "--help" option
            ->addArgument('nickname', InputArgument::REQUIRED, 'The nickname of user.')
            ->setHelp('This command allows you to create a new user. User code will be returned');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $cmd = new RegisterUserCommand( $input->getArgument('nickname'));
        $envelope = $this->bus->dispatch($cmd);
        $handledStamp = $envelope->last(HandledStamp::class);
        $output->writeln("New user created: " . $handledStamp->getResult());
        return Command::SUCCESS;
    }
}