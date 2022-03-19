<?php

namespace App\Machine\Exceptions;

class InsufficientMachineItems extends \Exception
{
    public static function insufficientCigaretteBoxes(): self
    {
        return new self('Insufficient cigarette boxes in machine');

    }
}