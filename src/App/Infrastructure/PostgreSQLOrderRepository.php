<?php


namespace GetWith\CoffeeMachine\App\Infrastructure;

use GetWith\CoffeeMachine\App\Domain\Order;
use GetWith\CoffeeMachine\App\Domain\OrderRepositoryInterface;
use GetWith\CoffeeMachine\Shared\Infrastructure\PostgreSQLPdoClient;

class PostgreSQLOrderRepository implements OrderRepositoryInterface
{
    /**
     * @var Order
     */
    protected Order $order;

    /**
     * Repository constructor.
     *
     * @param Order $order
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * @return array
     * Refactor to queryBus
     * Return Collection Orders
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
     * @param array $params
     * Entity Order
     * persist
     * flush
     */
    public function save(array $params): void
    {
        $pdo = PostgreSQLPdoClient::getPdo();
        $sql = 'INSERT INTO orders(drink_type, sugars, stick, extra_hot)
                VALUES (:drink_type, :sugars, :stick, :extra_hot)';
        $stmt= $pdo->prepare($sql);
        $stmt->execute($params);

        //ideal
        //return $this->db->insert(self::ORDERS, $orders->toPersistence());
    }
}
