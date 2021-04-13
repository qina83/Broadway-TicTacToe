<?php

/*
 * This file is part of the broadway/broadway-demo package.
 *
 * (c) 2020 Broadway project
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Identity\Infrastructure\CLI;

use App\Identity\Infrastructure\DBAL\EnableUserDBALRepository;
use Broadway\EventStore\EventStore;
use Doctrine\DBAL\Connection;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Creates the read model table.
 */
class CreateEnableUserRMCommand extends Command
{
    private EnableUserDBALRepository $repository;
    private Connection $connection;
    protected static $defaultName = 'app:read-model:enable-user:create';

    public function __construct(Connection $connection, EnableUserDBALRepository $repository)
    {
        parent::__construct();

        $this->repository = $repository;
        $this->connection = $connection;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $schemaManager = $this->connection->getSchemaManager();

        if ($table = $this->repository->configureSchema($schemaManager->createSchema())) {
            $schemaManager->createTable($table);
            $output->writeln('<info>Created Broadway read model schema</info>');
        } else {
            $output->writeln('<info>Broadway read model schema already exists</info>');
        }

        return Command::SUCCESS;
    }
}
