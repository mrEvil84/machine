<?php

declare(strict_types=1);

namespace App\Machine\DomainModel\ValueObjects;

use App\Machine\Exceptions\InvalidValue;

class PaidAmount
{
    const NAME = 'PaidAmount';

    /**
     * @var float
     */
    private $paidAmount;

    /**
     * @param float $paidAmount
     * @throws InvalidValue
     */
    public function __construct(float $paidAmount)
    {
        if ($paidAmount < 0.0) {
            throw InvalidValue::createWithFieldName(self::NAME);
        }
        $this->paidAmount = $paidAmount;
    }

    public function getPaidAmountValue(): float
    {
        return $this->paidAmount;
    }

}