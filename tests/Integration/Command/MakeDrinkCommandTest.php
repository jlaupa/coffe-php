<?php

namespace GetWith\CoffeeMachine\Tests\Integration\Command;

use GetWith\CoffeeMachine\App\Application\MakeDrinkCommand;
use GetWith\CoffeeMachine\App\Infrastructure\PostgreSQLOrderRepository;
use GetWith\CoffeeMachine\Tests\Integration\IntegrationTestCase;
use Symfony\Component\Console\Tester\CommandTester;

class MakeDrinkCommandTest extends IntegrationTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->application->add(
            new MakeDrinkCommand(
                new PostgreSQLOrderRepository()
            )
        );
    }

    /**
     * @dataProvider ordersProvider
     * @param string $drinkType
     * @param string $money
     * @param int $sugars
     * @param int $extraHot
     * @param string $expectedOutput
     */
    public function testCoffeeMachineReturnsTheExpectedOutput(
        string $drinkType,
        string $money,
        int $sugars,
        int $extraHot,
        string $expectedOutput
    ): void {
        $command = $this->application->find('app:order-drink');
        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'command'  => $command->getName(),
            'drink-type' => $drinkType,
            'money' => $money,
            'sugars' => $sugars,
            '--extra-hot' => $extraHot,
        ]);
        $output = $commandTester->getDisplay();
        $this->assertSame($expectedOutput, $output);
    }

    public function ordersProvider(): array
    {
        return [
            [
                'home', '1000', 1, 1, 'The drink type should be tea, coffee or chocolate.' . PHP_EOL
            ],
            [
                'chocolate', '0.7', 1, 0, 'You have ordered a chocolate with 1 sugars (stick included)' . PHP_EOL
            ],
            [
                'coffee', '2', 2, 1, 'You have ordered a coffee extra hot with 2 sugars (stick included)' . PHP_EOL
            ],
            [
                'tea', '0.4', 0, 1, 'You have ordered a tea extra hot' . PHP_EOL
            ],
            [
                'coffee', '0.2', 2, 1, 'The coffee costs 0.5.' . PHP_EOL
            ],
            [
                'chocolate', '0.3', 2, 1, 'The chocolate costs 0.6.' . PHP_EOL
            ],
            [
                'tea', '0.1', 2, 1, 'The tea costs 0.4.' . PHP_EOL
            ],
            [
                'tea', '0.5', -1, 1, 'The number of sugars should be between 0 and 2.' . PHP_EOL
            ],
            [
                'tea', '0.5', 3, 1, 'The number of sugars should be between 0 and 2.' . PHP_EOL
            ],
        ];
    }
}
