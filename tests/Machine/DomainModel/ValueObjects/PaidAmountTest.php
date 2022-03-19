<?php

declare(strict_types=1);

namespace Tests\Machine\DomainModel\ValueObjects;

use App\Machine\DomainModel\ValueObjects\PaidAmount;
use App\Machine\Exceptions\InvalidValue;
use PHPUnit\Framework\TestCase;

class PaidAmountTest extends TestCase
{
    /**
     * @test
     */
    public function shouldGetPaidAmountValue()
    {
        $sut = new PaidAmount(10.22);

        $this->assertTrue(is_float($sut->getPaidAmountValue()));
        $this->assertEquals(10.22, $sut->getPaidAmountValue());
    }

    /**
     * @test
     */
    public function shouldNotGetPaidAmountValue()
    {
        $this->expectException(InvalidValue::class);
        new PaidAmount(-3.23);
    }
}
