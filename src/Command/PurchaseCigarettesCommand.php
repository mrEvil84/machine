<?php

declare(strict_types=1);

namespace App\Command;

use App\Machine\Application\Command\PurchaseItems;
use App\Machine\Application\MachineService;
use App\Machine\DomainModel\CigaretteMachine;
use App\Machine\DomainModel\ValueObjects\ItemQuantity;
use App\Machine\DomainModel\ValueObjects\PaidAmount;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class CigaretteMachine
 * @package App\Command
 */
class PurchaseCigarettesCommand extends Command
{
    /**
     * @return void
     */
    protected function configure()
    {
        $this->addArgument('packs', InputArgument::REQUIRED, "How many packs do you want to buy?");
        $this->addArgument('amount', InputArgument::REQUIRED, "The amount in euro.");
    }

    /**
     * @param InputInterface   $input
     * @param OutputInterface $output
     *
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $itemCount = (int) $input->getArgument('packs');
        $amount = (float) \str_replace(',', '.', $input->getArgument('amount'));

        $cigaretteMachine = MachineService::initializeEuroMachine();

        try {
            $command = new PurchaseItems(
                new ItemQuantity($itemCount),
                new PaidAmount($amount)
            );

            $purchasedItem = $cigaretteMachine->purchaseItems($command);

            $output->writeln('You bought <info>' . $purchasedItem->getItemQuantity() . '</info> packs of cigarettes for <info> -' . $purchasedItem->getTotalAmount() . '€' . '</info>, each for <info> -' . CigaretteMachine::ITEM_PRICE . '€' . '</info>. ');
            $output->writeln('Your change is: -' . $purchasedItem->getChangeAmount() . ' €');

            $table = new Table($output);
            $table
                ->setHeaders(['Coins', 'Count'])
                ->setRows($purchasedItem->getChange())
                ->render();

        } catch (\Exception $e) {
            $output->writeln('Error: ' . $e->getMessage());
        }
    }
}