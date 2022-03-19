<?php

declare(strict_types=1);

namespace App\Machine\Application;

use App\Machine\Application\Command\PurchaseTransactionInterface;
use App\Machine\DomainModel\CigaretteMachine;
use App\Machine\DomainModel\MachineInterface;
use App\Machine\SharedKernel\EuroCoinsChanger;
use App\Machine\SharedKernel\PurchasedItemInterface;

class MachineService
{
    private $machine;

    public function __construct(MachineInterface $machine) {
        $this->machine = $machine;
    }

    public static function initializeEuroMachine(): self
    {
        return new self(
            new CigaretteMachine(new EuroCoinsChanger())
        );
    }

    public function purchaseItems(PurchaseTransactionInterface $purchaseItems): PurchasedItemInterface
    {
        return $this->machine->execute($purchaseItems);
    }
}