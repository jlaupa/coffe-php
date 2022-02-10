<?php


namespace GetWith\CoffeeMachine\App\Domain;

use GetWith\CoffeeMachine\Exceptions\MakeDrinkValidationException;

interface DrinkInterface
{
    /**
     * @param string $drinkType
     * @throws MakeDrinkValidationException
     */
    public function validateDrinkType(string $drinkType): void;

    /**
     * @param string $drinkType
     * @param float $money
     * @throws MakeDrinkValidationException
     *
     *
     */
    public function evaluateCost(string $drinkType, float $money): void;

    /**
     * @param int $sugars
     * @throws MakeDrinkValidationException
     */
    public function validateSugar(int $sugars): void;
}
