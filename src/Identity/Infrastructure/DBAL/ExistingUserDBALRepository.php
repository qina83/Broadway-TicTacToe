<?php


namespace App\Identity\Infrastructure\DBAL;

use App\Identity\Application\ReadModel\ExistingUser;
use App\Identity\Domain\Repository\ExistingUserRepository;
use Broadway\ReadModel\Repository;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Schema\Table;

class ExistingUserDBALRepository implements ExistingUserRepository
{

    private const TABLE_NAME = 'rm_existing_user';
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
     * @return ExistingUser[]
     * @throws \Doctrine\DBAL\Exception
     */
    public function findAllExistingUsers(): array
    {
        $queryBuilder = $this->connection->createQueryBuilder();
        $usersDb = $queryBuilder
            ->select('*')
            ->from(self::TABLE_NAME)
            ->execute()
            ->fetchAllAssociative();

        $users = [];
        foreach ($usersDb as $userDB) {
            $users[] = ExistingUserMapper::deserialize($userDB);
        }
        return $users;
    }

    /**
     * @param string $id
     * @return ExistingUser|null
     * @throws \Doctrine\DBAL\Exception
     */
    public function findExitingUserById(string $id): ?ExistingUser
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

        return ExistingUserMapper::deserialize($userDb[0]);

    }

    public function updateExistingUser(ExistingUser $exUSer): void
    {
        $queryBuilder = $this->connection->createQueryBuilder();
        $queryBuilder
            ->update(self::TABLE_NAME)
            ->set('nickname','?')
            ->set('enable','?')
            ->where('uuid=?')
            ->setParameter(0, $exUSer->getNickname())
            ->setParameter(1, intval($exUSer->isEnable()))
            ->setParameter(2, $exUSer->getId());

        $queryBuilder->execute();
    }

    public function saveExistingUser(ExistingUser $exUSer): void
    {
        $queryBuilder = $this->connection->createQueryBuilder();
        $queryBuilder
            ->insert(self::TABLE_NAME)
            ->values([
                'uuid' => '?',
                'nickname' => '?',
                'enable' => '?'
            ])
            ->setParameter(0, $exUSer->getId())
            ->setParameter(1, $exUSer->getNickname())
            ->setParameter(2, $exUSer->isEnable());

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
        $table->addColumn('enable', 'boolean');
        $table->setPrimaryKey(['uuid']);

        return $table;
    }
}