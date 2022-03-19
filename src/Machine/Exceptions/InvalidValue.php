<?php

namespace App\Machine\Exceptions;

class InvalidValue extends \Exception
{
    const MESSAGE = 'Invalid value exception of: ';

    public static function createWithFieldName(string $fieldName): self
    {
        return new self(self::MESSAGE . $fieldName);
    }
}
