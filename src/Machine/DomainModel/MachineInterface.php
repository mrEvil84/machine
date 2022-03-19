<?php

namespace App\Machine\DomainModel;

use App\Machine\Application\Command\PurchaseTransactionInterface;
use App\Machine\SharedKernel\PurchasedItemInterface;

/**
 * Interface CigaretteMachine
 * @package App\Machine
 */
interface MachineInterface
{
    /**
     * @param PurchaseTransactionInterface $purchaseTransaction
     *
     * @return PurchasedItemInterface
     */
    public function execute(PurchaseTransactionInterface $purchaseTransaction): PurchasedItemInterface;

    public function assertBusinessRules(PurchaseTransactionInterface $purchaseTransaction);
}