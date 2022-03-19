<?php

declare(strict_types=1);

namespace App\Machine\SharedKernel;

class EuroCoinsChanger implements CoinsChanger
{
    const EURO_COINS_TRANSLATOR = [
        '2.0' => 200,
        '1.0' => 100,
        '0.50' => 50,
        '0.20' => 20,
        '0.10' => 10,
        '0.05' => 5,
        '0.02' => 2,
        '0.01' => 1
    ];
    private $coinsCounter = [];
    private $coinsTranslator;

    public function __construct(array $coinsTranslator = self::EURO_COINS_TRANSLATOR)
    {
        $this->coinsTranslator = $coinsTranslator;
    }

    public function getChange(float $amount): array
    {
        $this->calculateCoinsAmount($amount);
        return $this->coinsCounter;
    }

    private function getFirstElementFromAssocData(array $assocData): array
    {
        list($k) = array_keys($assocData);
        return [$k => $assocData[$k]];
    }

    private function getCoinsDivisionStats(float $normalizedAmount): array
    {
        $coinDivisionStats = [];
        foreach ($this->coinsTranslator as $coinName => $coinValue) {
            $coinDivisionStats[$coinName] = round($normalizedAmount / $coinValue,2);
        }
        return $coinDivisionStats;
    }

    private function getMinPositiveCoinDivisionStats(array $coinDivisionStats): array
    {
        asort($coinDivisionStats); // sort, small value on the top

        $positive = array_filter($coinDivisionStats, static function ($number) {
            return $number >= 1.00;
        });

        return $this->getFirstElementFromAssocData($positive);
    }

    private function updateCoinCounter(string $coinKey, float $coinItemCount)
    {
        if (array_key_exists($coinKey, $this->coinsCounter)) {
            $value = $this->coinsCounter[$coinKey];
            $this->coinsCounter[$coinKey] = $value + (int)$coinItemCount;
        } else {
            $this->coinsCounter[$coinKey] = (int)$coinItemCount;
        }
    }

    private function calculateCoinsAmount(float $amount)
    {
        if ($amount < 0.01) {
            return;
        }
        $amount = round($amount,2);

        $normalizedAmount = $amount * 100;

        $coinDivisionStats = $this->getCoinsDivisionStats($normalizedAmount);

        $smallest = $this->getMinPositiveCoinDivisionStats($coinDivisionStats);

        $smallestKey = array_keys($smallest)[0];
        $smallestValue = array_values($smallest)[0];

        $this->updateCoinCounter($smallestKey, $smallestValue);

        // subtract from normalized amount multiplied coin value
        $newAmount = round(
            ($normalizedAmount - ((int)$smallestValue * $this->coinsTranslator[$smallestKey])) / 100,
            2
        );

        if ($newAmount <= 0) {
            return;
        }
        $this->calculateCoinsAmount($newAmount);
    }
}
