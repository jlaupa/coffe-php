<?php


namespace GetWith\CoffeeMachine\App\Infrastructure;

use GetWith\CoffeeMachine\App\Domain\Order;
use GetWith\CoffeeMachine\App\Domain\OrderRepositoryInterface;
use GetWith\CoffeeMachine\Shared\Infrastructure\PostgreSQLPdoClient;

class PostgreSQLOrderRepository implements OrderRepositoryInterface
{
    /**
     * @return array
     * Refactor to queryBus
     * Return Collection OrdersByDrinkType
     */
    public function getOrdersByDrinkType(): array
    {
        $pdo = PostgreSQLPdoClient::getPdo();
        $sql = 'SELECT count(1) as count, drink_type 
                FROM orders
                GROUP BY drink_type';
        $query = $pdo->query($sql);

        return $query->fetchAll();
    }

    /**
     * persist
     * flush
     */
    public function save(Order $order): void
    {
        $orderPersist = $order->toArray();

        $pdo = PostgreSQLPdoClient::getPdo();
        $sql = 'INSERT INTO orders(drink_type, sugars, stick, extra_hot)
                VALUES (:drink_type, :sugars, :stick, :extra_hot)';
        $stmt = $pdo->prepare($sql);

        $stmt->execute($orderPersist);
    }
}
