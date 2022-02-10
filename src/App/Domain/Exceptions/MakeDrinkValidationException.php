<?php

namespace GetWith\CoffeeMachine\App\Domain\Exceptions;

class MakeDrinkValidationException extends \Exception
{
    /**
     * MakeDrinkValidationException constructor.
     * @param null $message
     * @param int $code
     * @param \Exception|null $previous
     */
    public function __construct($message = null, $code = 0, \Exception $previous = null)
    {
        if (null === $message) {
            $message = 'validation failed';
        }

        parent::__construct($message, $code, $previous);
    }
}
