<?php

namespace Utils;

use Momento\Cache\Utils\RangeValue;
use PHPUnit\Framework\TestCase;

class RangeValueTest extends TestCase
{
    public function testRangeValueParsesInteger(): void
    {
        // Test inclusive integer parsing
        $rangeValue = RangeValue::parse(5);
        $this->assertEquals(5, $rangeValue->getValue());
        $this->assertTrue($rangeValue->isInclusive());
        $this->assertTrue($rangeValue->isFinite());

        $rangeValue = RangeValue::parse(-1);
        $this->assertEquals(-1, $rangeValue->getValue());
        $this->assertTrue($rangeValue->isInclusive());
        $this->assertTrue($rangeValue->isFinite());
    }

    public function testRangeValueParsesFloat(): void
    {
        // Test inclusive float parsing
        $rangeValue = RangeValue::parse(5.75);
        $this->assertEquals(5.75, $rangeValue->getValue());
        $this->assertTrue($rangeValue->isInclusive());

        $rangeValue = RangeValue::parse(-1.25);
        $this->assertEquals(-1.25, $rangeValue->getValue());
        $this->assertTrue($rangeValue->isInclusive());
    }

    public function testRangeValueParsesStringInteger(): void
    {
        // Test string-based integer parsing
        $rangeValue = RangeValue::parse("5");
        $this->assertEquals(5, $rangeValue->getValue());
        $this->assertTrue($rangeValue->isInclusive());

        $rangeValue = RangeValue::parse("-1");
        $this->assertEquals(-1, $rangeValue->getValue());
        $this->assertTrue($rangeValue->isInclusive());
    }

    public function testRangeValueParsesStringFloat(): void
    {
        // Test string-based float parsing
        $rangeValue = RangeValue::parse("5.75");
        $this->assertEquals(5.75, $rangeValue->getValue());
        $this->assertTrue($rangeValue->isInclusive());

        $rangeValue = RangeValue::parse("-1.25");
        $this->assertEquals(-1.25, $rangeValue->getValue());
        $this->assertTrue($rangeValue->isInclusive());
    }

    public function testRangeValueParsesExclusiveStringInteger(): void
    {
        // Test exclusive integer parsing from string
        $rangeValue = RangeValue::parse("(5");
        $this->assertEquals(5, $rangeValue->getValue());
        $this->assertFalse($rangeValue->isInclusive());

        $rangeValue = RangeValue::parse("(-1");
        $this->assertEquals(-1, $rangeValue->getValue());
        $this->assertFalse($rangeValue->isInclusive());
    }

    public function testRangeValueParsesExclusiveStringFloat(): void
    {
        // Test exclusive float parsing from string
        $rangeValue = RangeValue::parse("(5.75");
        $this->assertEquals(5.75, $rangeValue->getValue());
        $this->assertFalse($rangeValue->isInclusive());

        $rangeValue = RangeValue::parse("(-1.25");
        $this->assertEquals(-1.25, $rangeValue->getValue());
        $this->assertFalse($rangeValue->isInclusive());
    }

    public function testRangeValueParsesPositiveInfinity(): void
    {
        // Test positive infinity
        $rangeValue = RangeValue::parse("+inf");
        $this->assertEquals("+inf", $rangeValue->getValue());
        $this->assertFalse($rangeValue->isInclusive());
        $this->assertTrue($rangeValue->isPositiveInfinity());
        $this->assertFalse($rangeValue->isFinite());

        $rangeValue = RangeValue::parse("+INF");
        $this->assertEquals("+inf", $rangeValue->getValue());
        $this->assertFalse($rangeValue->isInclusive());
        $this->assertTrue($rangeValue->isPositiveInfinity());
        $this->assertFalse($rangeValue->isFinite());
    }

    public function testRangeValueParsesNegativeInfinity(): void
    {
        // Test negative infinity
        $rangeValue = RangeValue::parse("-inf");
        $this->assertEquals("-inf", $rangeValue->getValue());
        $this->assertFalse($rangeValue->isInclusive());
        $this->assertTrue($rangeValue->isNegativeInfinity());

        $rangeValue = RangeValue::parse("-INF");
        $this->assertEquals("-inf", $rangeValue->getValue());
        $this->assertFalse($rangeValue->isInclusive());
        $this->assertTrue($rangeValue->isNegativeInfinity());
    }

    public function testInvalidRangeValueThrowsException(): void
    {
        // Test invalid string throws exception
        $this->expectException(\InvalidArgumentException::class);
        RangeValue::parse("invalid");

        // Test invalid characters that are not numbers or parenthesis
        $this->expectException(\InvalidArgumentException::class);
        RangeValue::parse("abc");
    }
}
