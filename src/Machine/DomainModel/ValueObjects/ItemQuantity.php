<?php

declare(strict_types=1);

namespace App\Machine\DomainModel\ValueObjects;

use App\Machine\Exceptions\InvalidValue;

class ItemQuantity
{
    const NAME = 'ItemQuantity';

    private $itemQuantity;

    /**
     * @param int $itemQuantity
     * @throws InvalidValue
     */
    public function __construct(int $itemQuantity)
    {
        if ($itemQuantity < 0) {
            throw InvalidValue::createWithFieldName(self::NAME);
        }
        $this->itemQuantity = $itemQuantity;
    }

    /**
     * @return int
     */
    public function getItemQuantityValue(): int
    {
        return $this->itemQuantity;
    }
}