<?php

namespace Utils;

use Momento\Cache\Utils\ZunionstoreOptionsHelper;
use PHPUnit\Framework\TestCase;

class ZunionstoreOptionsHelperTest extends TestCase
{
    public function testValidateAndPrepareWeights_WithNullWeights_ShouldReturnDefaultWeights(): void
    {
        $keyCount = 3;
        $weights = null;
        $expected = [1.0, 1.0, 1.0];

        $result = ZunionstoreOptionsHelper::validateAndPrepareWeights($weights, $keyCount);
        $this->assertEquals($expected, $result, "Default weights should be [1.0, 1.0, 1.0]");
    }

    public function testValidateAndPrepareWeights_WithValidWeights_ShouldReturnWeights(): void
    {
        $keyCount = 3;
        $weights = [2.0, 3.5, 1.0];

        $result = ZunionstoreOptionsHelper::validateAndPrepareWeights($weights, $keyCount);
        $this->assertEquals($weights, $result, "Weights should be returned as provided.");
    }

    public function testValidateAndPrepareWeights_WithMismatchedCount_ShouldThrowException(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Number of weights must match the number of keys.");

        $keyCount = 3;
        $weights = [2.0, 3.5]; // Only two weights for three keys

        ZunionstoreOptionsHelper::validateAndPrepareWeights($weights, $keyCount);
    }

    public function testValidateAndPrepareWeights_WithNonNumericWeight_ShouldThrowException(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("All weights must be integers or floats.");

        $keyCount = 3;
        $weights = [2.0, "invalid", 1.0]; // One of the weights is a string

        ZunionstoreOptionsHelper::validateAndPrepareWeights($weights, $keyCount);
    }

    public function testValidateAndPrepareAggregate_WithNullAggregate_ShouldReturnSum(): void
    {
        $aggregate = null;
        $expected = ZunionstoreOptionsHelper::AGGREGATE_SUM;

        $result = ZunionstoreOptionsHelper::validateAndPrepareAggregate($aggregate);
        $this->assertEquals($expected, $result, "Aggregate should default to 'sum'.");
    }

    public function testValidateAndPrepareAggregate_WithValidAggregate_ShouldReturnAggregate(): void
    {
        $aggregate = 'MIN';
        $expected = ZunionstoreOptionsHelper::AGGREGATE_MIN;

        $result = ZunionstoreOptionsHelper::validateAndPrepareAggregate($aggregate);
        $this->assertEquals($expected, $result, "Aggregate should return 'min'.");
    }

    public function testValidateAndPrepareAggregate_WithInvalidAggregate_ShouldThrowException(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Invalid aggregate option. Must be 'sum', 'min', or 'max'.");

        $aggregate = 'invalid'; // Invalid aggregation function

        ZunionstoreOptionsHelper::validateAndPrepareAggregate($aggregate);
    }

    public function testValidateAndPrepareWeights_WithIntegerWeights_ShouldPass(): void
    {
        $keyCount = 3;
        $weights = [1, 2, 3];

        $result = ZunionstoreOptionsHelper::validateAndPrepareWeights($weights, $keyCount);
        $this->assertEquals($weights, $result, "Integer weights should be allowed and returned as-is.");
    }

    public function testValidateAndPrepareWeights_WithMixedNumericWeights_ShouldPass(): void
    {
        $keyCount = 3;
        $weights = [1, 2.5, 3];

        $result = ZunionstoreOptionsHelper::validateAndPrepareWeights($weights, $keyCount);
        $this->assertEquals($weights, $result, "Mixed integer and float weights should be allowed.");
    }

    public function testValidateAndPrepareAggregate_CaseInsensitive_ShouldPass(): void
    {
        $aggregate = 'MiN'; // Case-insensitive input
        $expected = ZunionstoreOptionsHelper::AGGREGATE_MIN;

        $result = ZunionstoreOptionsHelper::validateAndPrepareAggregate($aggregate);
        $this->assertEquals($expected, $result, "Aggregate function should be case-insensitive.");
    }

    public function testValidateAndPrepareAggregate_WithSum_ShouldReturnSum(): void
    {
        $aggregate = 'sum';
        $expected = ZunionstoreOptionsHelper::AGGREGATE_SUM;

        $result = ZunionstoreOptionsHelper::validateAndPrepareAggregate($aggregate);
        $this->assertEquals($expected, $result, "Aggregate should return 'sum'.");
    }

    public function testValidateAndPrepareAggregate_WithMax_ShouldReturnMax(): void
    {
        $aggregate = 'max';
        $expected = ZunionstoreOptionsHelper::AGGREGATE_MAX;

        $result = ZunionstoreOptionsHelper::validateAndPrepareAggregate($aggregate);
        $this->assertEquals($expected, $result, "Aggregate should return 'max'.");
    }

    public function testValidateAndPrepareAggregate_WithUpperCaseSum_ShouldReturnSum(): void
    {
        $aggregate = 'SuM'; // Case-insensitive input
        $expected = ZunionstoreOptionsHelper::AGGREGATE_SUM;

        $result = ZunionstoreOptionsHelper::validateAndPrepareAggregate($aggregate);
        $this->assertEquals($expected, $result, "Aggregate should return 'sum', case-insensitively.");
    }

    public function testValidateAndPrepareAggregate_WithUpperCaseMax_ShouldReturnMax(): void
    {
        $aggregate = 'MAX'; // Case-insensitive input
        $expected = ZunionstoreOptionsHelper::AGGREGATE_MAX;

        $result = ZunionstoreOptionsHelper::validateAndPrepareAggregate($aggregate);
        $this->assertEquals($expected, $result, "Aggregate should return 'max', case-insensitively.");
    }
}
