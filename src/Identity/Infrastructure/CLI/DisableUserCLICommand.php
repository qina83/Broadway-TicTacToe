<?php


namespace App\Identity\Infrastructure\CLI;

use App\Identity\Domain\Command\DisableUserCommand;
use App\Identity\Domain\Command\RegisterUserCommand;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

class DisableUserCLICommand extends Command
{
    protected static $defaultName = 'app:disable-user';
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
            // the short description shown while running "php bin/console list"
            ->setDescription('Disable a user')

            // the full command description shown when running the command with
            // the "--help" option
            ->addArgument('userId', InputArgument::REQUIRED, 'The id of user.')
            ->setHelp('This command allows you to disable a user');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $cmd = new DisableUserCommand( $input->getArgument('userId'));
        $envelope = $this->bus->dispatch($cmd);
        $handledStamp = $envelope->last(HandledStamp::class);
        $output->writeln("User disabled: " . $handledStamp->getResult());
        return Command::SUCCESS;
    }
}