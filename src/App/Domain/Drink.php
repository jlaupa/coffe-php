<?php


namespace GetWith\CoffeeMachine\App\Domain;

use GetWith\CoffeeMachine\App\Domain\Exceptions\MakeDrinkValidationException;

class Drink implements DrinkInterface
{
    public const TEA = 'tea';
    public const COFFEE = 'coffee';
    public const CHOCOLATE = 'chocolate';

    public const PRICES = [
        self::TEA => 0.4,
        self::COFFEE => 0.5,
        self::CHOCOLATE => 0.6
    ];
}
