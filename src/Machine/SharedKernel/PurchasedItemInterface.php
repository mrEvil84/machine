<?php

declare(strict_types=1);

namespace App\Machine\SharedKernel;

/**
 * Interface PurchasedItemInterface
 * @package App\Machine
 */
interface PurchasedItemInterface
{
    /**
     * @return integer
     */
    public function getItemQuantity():int;

    /**
     * @return float
     */
    public function getTotalAmount():float;

    /**
     * Returns the change in this format:
     *
     * Coin Count
     * 0.01 0
     * 0.02 0
     * .... .....
     *
     * @return array
     */
    public function getChange(): array;

    public function getChangeAmount(): float;
}