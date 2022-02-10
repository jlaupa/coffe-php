<?php


namespace GetWith\CoffeeMachine\App\Domain;

interface OrderRepositoryInterface
{
    /**
     * @return array
     */
    public function getOrdersByDrinkType(): array;


    /**
     * @param array $params
     */
    public function save(array $params): void;
}
