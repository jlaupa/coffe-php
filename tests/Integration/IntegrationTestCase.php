<?php

namespace GetWith\CoffeeMachine\Tests\Integration;

use GetWith\CoffeeMachine\Shared\Infrastructure\PostgreSQLPdoClient;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Application;

class IntegrationTestCase extends TestCase
{
    protected Application $application;
    protected \PDO $pdo;

    protected function setUp(): void
    {
        parent::setUp();

        $this->application = new Application();
        $this->pdo = PostgreSQLPdoClient::getPdo();
        $this->pdo->beginTransaction();
    }

    protected function tearDown(): void
    {
        $this->pdo->rollBack();
        unset($this->pdo);

        parent::tearDown();
    }
}
