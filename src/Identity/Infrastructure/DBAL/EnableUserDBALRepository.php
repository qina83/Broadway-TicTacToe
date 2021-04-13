<?php


namespace App\Identity\Infrastructure\DBAL;

use App\Identity\Application\ReadModel\EnableUser;
use App\Identity\Application\ReadModel\ExistingUser;
use App\Identity\Domain\Repository\EnableUserRepository;
use App\Identity\Domain\Repository\ExistingUserRepository;
use Broadway\ReadModel\Repository;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Schema\Table;

class EnableUserDBALRepository implements EnableUserRepository
{

    private const TABLE_NAME = 'rm_enable_user';
    private Connection $connection;

    /**
     * GamePersisterDBAL constructor.
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @return EnableUser[]
     * @throws \Doctrine\DBAL\Exception
     */
    public function findAllEnableUsers(): array
    {
        $queryBuilder = $this->connection->createQueryBuilder();
        $usersDb = $queryBuilder
            ->select('*')
            ->from(self::TABLE_NAME)
            ->execute()
            ->fetchAllAssociative();

        $users = [];
        foreach ($usersDb as $userDB) {
            $users[] = EnableUserMapper::deserialize($userDB);
        }
        return $users;
    }

    /**
     * @param string $id
     * @return EnableUser|null
     * @throws \Doctrine\DBAL\Exception
     */
    public function findEnableUserById(string $id): ?EnableUser
    {
        $queryBuilder = $this->connection->createQueryBuilder();
        $userDb = $queryBuilder
            ->select('*')
            ->from(self::TABLE_NAME)
            ->where('uuid = ?')
            ->setParameter(0, $id)
            ->execute()
            ->fetchAllAssociative();

        if (0 == \count($userDb)) {
            return null;
        }

        return EnableUserMapper::deserialize($userDb[0]);

    }

    public function updateEnableUser(EnableUser $enUser): void
    {
        $queryBuilder = $this->connection->createQueryBuilder();
        $queryBuilder
            ->update(self::TABLE_NAME)
            ->set('nickname','?')
            ->where('uuid=?')
            ->setParameter(0, $enUser->getNickname())
            ->setParameter(1, $enUser->getId());

        $queryBuilder->execute();
    }

    public function saveEnableUser(EnableUser $enUser): void
    {
        $queryBuilder = $this->connection->createQueryBuilder();
        $queryBuilder
            ->insert(self::TABLE_NAME)
            ->values([
                'uuid' => '?',
                'nickname' => '?'
            ])
            ->setParameter(0, $enUser->getId())
            ->setParameter(1, $enUser->getNickname());

        $queryBuilder->execute();
    }

    public function configureSchema(Schema $schema)
    {
        if ($schema->hasTable(self::TABLE_NAME)) {
            return null;
        }

        return $this->configureTable($schema);
    }

    private function configureTable(Schema $schema): Table
    {
        $table = $schema->createTable(self::TABLE_NAME);
        $table->addColumn('uuid', 'guid', ['length' => 36]);
        $table->addColumn('nickname', 'text');
        $table->setPrimaryKey(['uuid']);

        return $table;
    }

    public function removeEnableUser(string $id): void
    {
        $queryBuilder = $this->connection->createQueryBuilder();
        $queryBuilder
            ->delete(self::TABLE_NAME)
            ->where('uuid=?')
            ->setParameter(0, $id);

        $queryBuilder->execute();
    }
}