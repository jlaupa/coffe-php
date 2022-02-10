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

    /**
     * @param string $drinkType
     * @throws MakeDrinkValidationException
     */
    public function validateDrinkType(string $drinkType): void
    {
        if (!in_array($drinkType, [self::TEA, self::COFFEE, self::CHOCOLATE])) {
            throw new MakeDrinkValidationException('The drink type should be tea, coffee or chocolate.');
        }
    }

    /**
     * @param string $drinkType
     * @param float $money
     * @throws MakeDrinkValidationException
     *
     *
     */
    public function evaluateCost(string $drinkType, float $money): void
    {
        $price = self::PRICES[$drinkType];
        if ($money < $price) {
            throw new MakeDrinkValidationException("The $drinkType costs $price.");
        }
    }

    /**
     * @param int $sugars
     * @throws MakeDrinkValidationException
     */
    public function validateSugar(int $sugars): void
    {
        $options = [0, 1, 2];
        if (!in_array($sugars, $options)) {
            throw new MakeDrinkValidationException('The number of sugars should be between 0 and 2.');
        }
    }
}
