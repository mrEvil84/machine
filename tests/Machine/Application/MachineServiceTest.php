<?php

declare(strict_types=1);

namespace Tests\Machine\Application;

use App\Machine\Application\Command\PurchaseItems;
use App\Machine\Application\MachineService;
use App\Machine\DomainModel\CigaretteMachine;
use App\Machine\DomainModel\ValueObjects\ItemQuantity;
use App\Machine\DomainModel\ValueObjects\PaidAmount;
use PHPUnit\Framework\TestCase;

class MachineServiceTest extends TestCase
{
    /**
     * @test
     * @dataProvider getPurchaseItemsData
     */
    public function shouldPurchaseItems(int $itemQuantity, float $paidAmount)
    {
        $cigaretteMachineMock = $this->createMock(CigaretteMachine::class);
        $cigaretteMachineMock->expects(self::once())->method('execute');

        $sut = new MachineService($cigaretteMachineMock);

        $sut->purchaseItems(
            new PurchaseItems(
                new ItemQuantity($itemQuantity),
                new PaidAmount($paidAmount)
            )
        );
    }

    public function getPurchaseItemsData()
    {
        yield [
            'itemQuantity' => 1,
            'paidAmount' => 10.00,
        ];
        yield [
            'itemQuantity' => 2,
            'paidAmount' => 10.00,
        ];
    }
}
