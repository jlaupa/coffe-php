<?php

namespace GetWith\CoffeeMachine\App\Application;

use GetWith\CoffeeMachine\App\Domain\Drink;
use GetWith\CoffeeMachine\App\Domain\OrderRepositoryInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DrinksSoldCommand extends Command
{
    protected static $defaultName = 'app:drink-sold';

    private OrderRepositoryInterface $orderRepository;

    public function __construct(OrderRepositoryInterface $orderRepository, string $name = null)
    {
        parent::__construct($name);
        $this->orderRepository = $orderRepository;
    }


    protected function execute(InputInterface $input, OutputInterface $output):void
    {
        $ordersByDrink = $this->orderRepository->getOrdersByDrinkType();
        $padLength = 15;
        $output->writeln(str_pad("Drink", $padLength, '_') . "Money");
        foreach ($ordersByDrink as $orderByDrink) {
            $totalAmount = $orderByDrink['count'] * Drink::PRICES[$orderByDrink['drink_type']];
            $drinkType = str_pad($orderByDrink['drink_type'], $padLength, '_');
            $output->writeln("$drinkType-$totalAmount");
        }
    }
}
