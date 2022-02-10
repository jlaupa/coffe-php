<?php

namespace GetWith\CoffeeMachine\App\Application;

use GetWith\CoffeeMachine\App\Domain\Drink;
use GetWith\CoffeeMachine\App\Domain\OrderRepositoryInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class DrinksSoldCommand extends Command
{
    protected static $defaultName = 'app:drink-sold';

    private OrderRepositoryInterface $orderRepository;

    public function __construct(OrderRepositoryInterface $orderRepository)
    {
        parent::__construct();
        $this->orderRepository = $orderRepository;
    }

    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        //FindOrdersByDrinkQuery
        //FindOrdersByDrinkQueryHandle
        $ordersByDrink = $this->orderRepository->getOrdersByDrinkType();
        $drinkSoldResponse = [];
        foreach ($ordersByDrink as $key => $orderByDrink) {
            /// $rows[$key][] = $orderByDrink->getDrinkType();
            /// $rows[$key][] = $orderByDrink->getMoney();
            $drinkSoldResponse[$key][] = $orderByDrink['drink_type'];
            $drinkSoldResponse[$key][] = $orderByDrink['count'] * Drink::PRICES[$orderByDrink['drink_type']];
        }

        //return DrinkSoldCommandResponse($input, $output)
        $io = new SymfonyStyle($input, $output);
        $io->table(
            ['Drink', 'Money'],
            $drinkSoldResponse
        );
    }
}
