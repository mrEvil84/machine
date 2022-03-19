<?php

namespace Tests\Machine\DomainModel;

use App\Machine\Application\Command\PurchaseItems;
use App\Machine\DomainModel\CigaretteMachine;
use App\Machine\DomainModel\ValueObjects\ItemQuantity;
use App\Machine\DomainModel\ValueObjects\PaidAmount;
use App\Machine\Exceptions\InsufficientFunds;
use App\Machine\Exceptions\InsufficientMachineItems;
use App\Machine\SharedKernel\EuroCoinsChanger;
use App\Machine\SharedKernel\PurchasedItemInterface;
use PHPUnit\Framework\TestCase;

class CigaretteMachineTest extends TestCase
{
    /**
     * @test
     * @dataProvider getPurchaseItemsData
     */
    public function shouldExecute(int $itemQuantity, float $paidAmount, float $expectedPriceForItems, float $expectedChangeAmount)
    {
        $sut = new CigaretteMachine(new EuroCoinsChanger());

        $purchasedItem = $sut->execute(
            new PurchaseItems(
                new ItemQuantity($itemQuantity),
                new PaidAmount($paidAmount)
            )
        );

        $this->assertInstanceOf(PurchasedItemInterface::class, $purchasedItem);
        $this->assertEquals($expectedPriceForItems, $purchasedItem->getTotalAmount());
        $this->assertEquals($expectedChangeAmount, $purchasedItem->getChangeAmount());
    }

    /**
     * @test
     * @dataProvider getInsufficientPurchaseItemsData
     */
    public function shouldNotExecute(int $itemQuantity, float $paidAmount, string $expectedException)
    {
        $sut = new CigaretteMachine(new EuroCoinsChanger());

        $this->expectException($expectedException);
        $sut->execute(
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
            'expectedPriceForItems' => 4.99,
            'expectedChangeAmount' => 5.01
        ];
        yield [
            'itemQuantity' => 2,
            'paidAmount' => 10.00,
            'expectedPriceForItems' => 9.98,
            'expectedChangeAmount' => 0.02
        ];
    }

    public function getInsufficientPurchaseItemsData()
    {
        yield [
            'itemQuantity' => 4,
            'paidAmount' => 10.00,
            'expectedException' => InsufficientFunds::class,
        ];
        yield [
            'itemQuantity' => 102,
            'paidAmount' => 1000.00,
            'expectedException' => InsufficientMachineItems::class,
        ];
    }
}
