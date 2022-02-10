<?php

namespace GetWith\CoffeeMachine\Shared\Infrastructure;

use PDO;
use PDOException;

final class PostgreSQLPdoClient
{
    private static $pdo;

    public static function getPdo(): PDO
    {
        if (!(self::$pdo instanceof PDO)) {
            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];
            //refactor params to env
            $dsn = "pgsql:host=coffe-postgre;port=5432;dbname=coffee;";
            try {
                self::$pdo = new PDO($dsn, 'coffee', 'coffee', $options);
            } catch (PDOException $e) {
                throw new PDOException($e->getMessage(), $e->getCode());
            }
        }

        return self::$pdo;
    }
}
