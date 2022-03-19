<?php

declare(strict_types=1);

namespace Tests\Machine\DomainModel\ValueObjects;

use App\Machine\DomainModel\ValueObjects\ItemQuantity;
use App\Machine\Exceptions\InvalidValue;
use PHPUnit\Framework\TestCase;

class ItemQuantityTest extends TestCase
{
    /**
     * @test
     */
    public function shouldGetItemQuantityValue()
    {
        $sut = new ItemQuantity(10);
        $this->assertTrue(is_int($sut->getItemQuantityValue()));
        $this->assertEquals(10, $sut->getItemQuantityValue());
    }

    /**
     * @test
     */
    public function shouldNotGetItemQuantityValue()
    {
        $this->expectException(InvalidValue::class);
        new ItemQuantity(-10);
    }

}
