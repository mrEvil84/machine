<?php

namespace App\Machine\SharedKernel;

class PurchasedItem implements PurchasedItemInterface
{
    /**
     * @var int
     */
    private $itemQuantity;
    /**
     * @var float
     */
    private $totalAmount;
    /**
     * @var array
     */
    private $change;
    /**
     * @var float
     */
    private $changeAmount;

    /**
     * @param int $itemQuantity
     * @param float $totalAmount
     * @param array $change
     * @param float $changeAmount
     */
    public function __construct(int $itemQuantity, float $totalAmount, array $change, float $changeAmount)
    {
        $this->itemQuantity = $itemQuantity;
        $this->totalAmount = $totalAmount;
        $this->change = $change;
        $this->changeAmount = $changeAmount;
    }

    /**
     * @return int
     */
    public function getItemQuantity(): int
    {
        return $this->itemQuantity;
    }

    /**
     * @return float
     */
    public function getTotalAmount(): float
    {
        return $this->totalAmount;
    }

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
    public function getChange(): array
    {
        $rows = [];
        foreach ($this->change as $coinName => $coinCount) {
            $rows [] = [$coinName,$coinCount];
        }

        return $rows;
    }

    public function getChangeAmount(): float
    {
        return $this->changeAmount;
    }
}