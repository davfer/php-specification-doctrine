<?php

namespace PhpSpecification\Doctrine\Test\Resources\Doctrine;

use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Doctrine\ORM\Query\ResultSetMapping;
use PhpSpecification\Doctrine\Test\Resources\Entities\User;
use PHPUnit\Framework\TestCase;

class DoctrineTestCase extends TestCase
{
    private ?EntityManager $entityManager = null;

    protected function createFixtures(): void
    {
        if ($this->entityManager === null) {
            $this->entityManager = $this->createEntityManager();
        }

        $this->entityManager->createNativeQuery(
            'DROP TABLE IF EXISTS `user`',
            new ResultSetMapping(),
        )->execute();

        $this->entityManager->createNativeQuery(
            'CREATE TABLE `user` (
                `id` INTEGER PRIMARY KEY AUTOINCREMENT,
                `name` VARCHAR(255) NOT NULL,
                `email` VARCHAR(255) NOT NULL
            )',
            new ResultSetMapping(),
        )->execute();

        $this->entityManager->createNativeQuery(
            'INSERT INTO `user` (`name`, `email`) VALUES
                ("John Doe", "test@example.com"),
                ("Jane Doe", "test2@example.com")',
            new ResultSetMapping(),
        )->execute();

        $u = new User();
        $u->name = 'Foo Bar';
        $u->email = 'foo@example.com';

        $this->entityManager->persist($u);
        $this->entityManager->flush();
    }

    /**
     * @param class-string $class
     */
    protected function getEntity(string $class, int $id): object
    {
        return $this->entityManager->find($class, $id);
    }

    protected function createEntityManager()
    {
        if ($this->entityManager !== null) {
            return $this->entityManager;
        }

        $config = ORMSetup::createAttributeMetadataConfiguration(
            paths: array(__DIR__ . "/src"),
            isDevMode: true,
        );
        $connection = DriverManager::getConnection([
            'driver' => 'pdo_sqlite',
            'path' => __DIR__ . '/db.sqlite',
        ], $config);

        return $this->entityManager = new EntityManager($connection, $config);
    }

}