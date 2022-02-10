<?php


namespace GetWith\CoffeeMachine\App\Domain;

interface OrderRepositoryInterface
{
    /**
     * @return array
     */
    public function getOrdersByDrinkType(): array;

    public function save(Order $order): void;
}
