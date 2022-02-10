<?php
declare(strict_types=1);

namespace  GetWith\CoffeeMachine\Validations;

use GetWith\CoffeeMachine\App\Domain\Drink;
use GetWith\CoffeeMachine\App\Domain\Exceptions\MakeDrinkValidationException;
use GetWith\CoffeeMachine\App\Domain\Order;

class OrderValidation
{
    private Order $order;

    public function __construct(
        Order $order
    ) {
        $this->order = $order;
    }

    public function execute():void
    {
        $this->validateDrinkType($this->order->getDrinkType());
        $this->evaluateCost($this->order->getDrinkType(), (float) $this->order->getMoney());
        $this->validateSugar($this->order->getSugars());
    }

    public function getOrder(): Order
    {
        return $this->order;
    }

    public function validateDrinkType(string $drinkType): void
    {
        if (!in_array($drinkType, [Drink::TEA, Drink::COFFEE, Drink::CHOCOLATE])) {
            throw new MakeDrinkValidationException('The drink type should be tea, coffee or chocolate.');
        }
    }

    public function evaluateCost(string $drinkType, float $money): void
    {
        $price = Drink::PRICES[$drinkType];
        if ($money < $price) {
            throw new MakeDrinkValidationException("The $drinkType costs $price.");
        }
    }

    public function validateSugar(int $sugars): void
    {
        if (!in_array($sugars, [0, 1, 2])) {
            throw new MakeDrinkValidationException('The number of sugars should be between 0 and 2.');
        }
    }

}
