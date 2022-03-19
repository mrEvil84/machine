<?php

declare(strict_types=1);

namespace App\Machine\Application\Command;

use App\Machine\DomainModel\ValueObjects\ItemQuantity;
use App\Machine\DomainModel\ValueObjects\PaidAmount;

class PurchaseItems implements PurchaseTransactionInterface
{
    /**
     * @var ItemQuantity
     */
    private $itemQuantity;
    /**
     * @var PaidAmount
     */
    private $paidAmount;

    /**
     * @param ItemQuantity $itemQuantity
     * @param PaidAmount $paidAmount
     */
    public function __construct(ItemQuantity $itemQuantity, PaidAmount $paidAmount)
    {
        $this->itemQuantity = $itemQuantity;
        $this->paidAmount = $paidAmount;
    }


    public function getItemQuantity(): int
    {
        return $this->itemQuantity->getItemQuantityValue();
    }

    public function getPaidAmount(): float
    {
        return $this->paidAmount->getPaidAmountValue();
    }

}