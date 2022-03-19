<?php

declare(strict_types=1);

namespace App\Machine\SharedKernel;

interface CoinsChanger
{
    public function getChange(float $amount): array;
}