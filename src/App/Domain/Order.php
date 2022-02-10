<?php


namespace GetWith\CoffeeMachine\App\Domain;

use GetWith\CoffeeMachine\Shared\Domain\Utils;

class Order implements OrderInterface
{
    private string $drinkType;
    private string $money;
    private ? int $sugars;
    private ? int $extraHot;
    private int $stick;

    public function __construct(string $drinkType, string $money, ?int $sugars, ?int $extraHot)
    {
        $this->drinkType = $drinkType;
        $this->money     = $money;
        $this->sugars    = $sugars;
        $this->extraHot  = $extraHot;
        $this->stick  = (int) ($this->getSugars() > 0);
    }

    public function getDrinkType(): string
    {
        return $this->drinkType;
    }

    public function getMoney(): string
    {
        return $this->money;
    }

    public function getSugars(): ?int
    {
        return $this->sugars;
    }


    public function getExtraHot(): ?int
    {
        return $this->extraHot;
    }

    public function getStick(): ?int
    {
        return $this->stick;
    }

    public function toArray(): array
    {
        $toArray = Utils::toArray($this);
        unset($toArray['money']);

        return$toArray;
    }
}
