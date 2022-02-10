#!/usr/bin/env php
<?php

require __DIR__.'/vendor/autoload.php';

use GetWith\CoffeeMachine\App\Application\DrinksSoldCommand;
use GetWith\CoffeeMachine\App\Application\MakeDrinkCommand;
use GetWith\CoffeeMachine\App\Infrastructure\PostgreSQLOrderRepository;
use Symfony\Component\Console\Application;

$application = new Application();
$orderRepository = new PostgreSQLOrderRepository();

$application->add(
    new MakeDrinkCommand($orderRepository)
)->setDescription('take drink orders.');

$application->add(
    new DrinksSoldCommand($orderRepository)
)->setDescription('money from drinks sold.');

$application->run();
