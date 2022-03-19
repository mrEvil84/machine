<?php

namespace App\Machine\Exceptions;

class InsufficientFunds extends \Exception
{
    public static function insufficientFunds(): self
    {
        return new self('Insufficient funds');
    }

}