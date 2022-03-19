<?php

declare(strict_types=1);

namespace Tests\Machine\SharedKernel;

use App\Machine\SharedKernel\EuroCoinsChanger;
use PHPUnit\Framework\TestCase;

class EuroCoinsChangerTest extends TestCase
{
    /**
     * @test
     * @dataProvider getChangesTestCases
     */
    public function shouldGetChange(float $change)
    {
        //given
        $sut = new EuroCoinsChanger();
        $obtainedChange = $sut->getChange($change);

        //when
        $value = 0;
        foreach ($obtainedChange as $coinName => $coinCount) {
            $coinValue = (float)$coinName;
            $value += $coinValue * $coinCount;
        }

        // then
        $this->assertEquals($change, $value);

    }

    public function getChangesTestCases(): \Generator
    {
        yield [0];
        yield [0.1];
        yield [1.2];
        yield [1.3];
        yield [1.4];
        yield [1.5];
        yield [1.22];
        yield [8.22];
    }
}
