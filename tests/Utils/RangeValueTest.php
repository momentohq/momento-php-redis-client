<?php

namespace Utils;

use Momento\Cache\Errors\InvalidArgumentError;
use Momento\Cache\Errors\NotImplementedException;
use Momento\Cache\MomentoCacheClient;
use Momento\Cache\Utils\RangeValue;
use PHPUnit\Framework\TestCase;
use SetupIntegrationTest;

class RangeValueTest extends TestCase
{
    public function testRangeValueParsesInteger(): void
    {
        $rangeValue = RangeValue::parse(5);
        $this->assertEquals(5, $rangeValue->getValue());
        $this->assertTrue($rangeValue->isInclusive());

        $rangeValue = RangeValue::parse(-1);
        $this->assertEquals(-1, $rangeValue->getValue());
        $this->assertTrue($rangeValue->isInclusive());
    }

    public function testRangeValueParsesString(): void
    {
        $rangeValue = RangeValue::parse("5");
        $this->assertEquals(5, $rangeValue->getValue());
        $this->assertTrue($rangeValue->isInclusive());

        $rangeValue = RangeValue::parse("-1");
        $this->assertEquals(-1, $rangeValue->getValue());
        $this->assertTrue($rangeValue->isInclusive());
    }

    public function testRangeValueParsesExclusiveString(): void
    {
        $rangeValue = RangeValue::parse("(5");
        $this->assertEquals(5, $rangeValue->getValue());
        $this->assertFalse($rangeValue->isInclusive());

        $rangeValue = RangeValue::parse("(-1");
        $this->assertEquals(-1, $rangeValue->getValue());
        $this->assertFalse($rangeValue->isInclusive());
    }

    public function testInvalidRangeValueThrowsException(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        RangeValue::parse("invalid");
    }
}
