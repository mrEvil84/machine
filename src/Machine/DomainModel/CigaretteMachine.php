<?php

declare(strict_types=1);

namespace App\Machine\DomainModel;

use App\Machine\Application\Command\PurchaseTransactionInterface;
use App\Machine\Exceptions\InsufficientFunds;
use App\Machine\Exceptions\InsufficientMachineItems;
use App\Machine\SharedKernel\CoinsChanger;
use App\Machine\SharedKernel\EuroCoinsChanger;
use App\Machine\SharedKernel\PurchasedItemInterface;
use App\Machine\SharedKernel\PurchasedItem;

/**
 * Class CigaretteMachine
 * @package App\Machine
 */
class CigaretteMachine implements MachineInterface
{
    const ITEM_PRICE = 4.99;
    const MAX_ITEM_TO_SELL = 100;
    /**
     * @var CoinsChanger
     */
    private $coinsChanger;
    /**
     * @var EuroCoinsChanger
     */
    private $moneyChanger;

    public function __construct(EuroCoinsChanger $moneyChanger)
    {
        $this->moneyChanger = $moneyChanger;
    }

    public function execute(PurchaseTransactionInterface $purchaseTransaction): PurchasedItemInterface
    {
        $this->assertBusinessRules($purchaseTransaction);

        $itemsToBuyCount = $purchaseTransaction->getItemQuantity();
        $priceForItems = $itemsToBuyCount * self::ITEM_PRICE;
        $change = round((float)($purchaseTransaction->getPaidAmount() - $priceForItems), 2);

        return new PurchasedItem(
            $itemsToBuyCount,
            (float)$priceForItems,
            $this->moneyChanger->getChange($change),
            $change
        );
    }

    private function getItemsCanBuy(PurchaseTransactionInterface $purchaseTransaction): int
    {
        $funds = $purchaseTransaction->getPaidAmount();
        return (int)($funds/self::ITEM_PRICE);
    }
    /**
     * @throws InsufficientFunds
     * @throws InsufficientMachineItems
     */
    public function assertBusinessRules(PurchaseTransactionInterface $purchaseTransaction)
    {
        if ($purchaseTransaction->getItemQuantity() > self::MAX_ITEM_TO_SELL) {
            throw InsufficientMachineItems::insufficientCigaretteBoxes();
        }

        $itemsCanBuy = $this->getItemsCanBuy($purchaseTransaction);
        if ($itemsCanBuy < $purchaseTransaction->getItemQuantity() || $itemsCanBuy === 0) {
            throw InsufficientFunds::insufficientFunds();
        }
    }
}