<?php

namespace GetWith\CoffeeMachine\App\Application;

use GetWith\CoffeeMachine\App\Domain\Exceptions\MakeDrinkValidationException;
use GetWith\CoffeeMachine\App\Domain\Order;
use GetWith\CoffeeMachine\App\Domain\OrderRepositoryInterface;
use GetWith\CoffeeMachine\Validations\OrderValidation;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class MakeDrinkCommand extends Command
{
    public const MONEY = 'money';
    public const SUGARS = 'sugars';
    public const EXTRA_HOT = 'extra-hot';
    public const DRINK_TYPE = 'drink-type';

    protected static $defaultName = 'app:order-drink';

    private OrderRepositoryInterface $orderRepository;

    public function __construct(
        OrderRepositoryInterface $orderRepository
    ) {
        parent::__construct();
        $this->orderRepository = $orderRepository;
    }

    protected function configure(): void
    {
        $this->requiredArgumentsForConfiguration();
        $this->optionArgumentsForConfiguration();
    }

    private function requiredArgumentsForConfiguration(): void
    {
        $arguments = [
            [
                'name' => self::DRINK_TYPE,
                'mode' => InputArgument::REQUIRED,
                'description' => 'The type of the drink. (Tea, Coffee or Chocolate)'
            ],
            [
                'name' => self::MONEY,
                'mode' => InputArgument::REQUIRED,
                'description' => 'The amount of money given by the user'
            ],
            [
                'name' => self::SUGARS,
                'mode' => InputArgument::OPTIONAL,
                'description' => 'The number of sugars you want. (0, 1, 2)',
                'default' => 0
            ],
        ];

        foreach ($arguments as $argument) {
            $this->addArgument(
                $argument['name'],
                $argument['mode'],
                $argument['description'],
                $argument['default'] ?? null
            );
        }
    }

    private function optionArgumentsForConfiguration(): void
    {
        $options = [
            [
                'name' => self::EXTRA_HOT,
                'shortcut' => 'e',
                'mode' => InputOption::VALUE_NONE,
                'description' => 'If the user wants to make the drink extra hot',
            ],
        ];

        foreach ($options as $option) {
            $this->addOption(
                $option['name'],
                $option['shortcut'],
                $option['mode'],
                $option['description']
            );
        }
    }

    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $drinkType = strtolower($input->getArgument(self::DRINK_TYPE));
        $money = $input->getArgument(self::MONEY);
        $sugars = (int) $input->getArgument(self::SUGARS);
        $extraHot = (int) $input->getOption(self::EXTRA_HOT);
        //BeginTransaction
        try {
            $order = new Order($drinkType, $money, $sugars, $extraHot);

            $this->validateRequest($order);

            //OrderCommand
            //OrderCommandHandler
            $this->orderRepository->save($order);

            //BeginTransaction::commit
            $this->printReturn($output, $order);
        } catch (MakeDrinkValidationException $makeDrinkValidationException) {
            //BeginTransaction::rollback
            $output->writeln($makeDrinkValidationException->getMessage());
        } catch (\Exception $e) {
            //BeginTransaction::rollback
            throw new \RuntimeException("SENTRY_LOG: ". $e->getMessage());
        }
    }

    private function validateRequest(Order $order): void
    {
        $validation = new OrderValidation($order);
        $validation->execute();
    }

    private function printReturn(OutputInterface $output, Order $order): void
    {
        $message = sprintf('You have ordered a %s', $order->getDrinkType());

        if ($order->getExtraHot()) {
            $message .= ' extra hot';
        }

        if ($order->getSugars() !== 0) {
            $message .= sprintf(' with %u sugars (stick included)', $order->getSugars());
        }

        $output->writeln($message);
    }
}
