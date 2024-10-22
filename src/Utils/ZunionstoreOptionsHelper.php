<?php

namespace Momento\Cache\Utils;

class ZunionstoreOptionsHelper
{
    // Static constants for aggregation options
    const AGGREGATE_SUM = 'sum';
    const AGGREGATE_MIN = 'min';
    const AGGREGATE_MAX = 'max';

    /**
     * Validates and normalizes the weights.
     *
     * @param array|null $weights The weights provided by the user.
     * @param int $keyCount The number of keys.
     * @return array The normalized weights array.
     * @throws \InvalidArgumentException if the weights are invalid.
     */
    public static function validateAndPrepareWeights(?array $weights, int $keyCount): array
    {
        if (is_null($weights)) {
            // Defaults to 1 for each key
            return array_fill(0, $keyCount, 1.0);
        }

        // Must have the same number of weights as keys
        if (count($weights) !== $keyCount) {
            throw new \InvalidArgumentException("Number of weights must match the number of keys.");
        }

        // Weights must be numeric
        foreach ($weights as $weight) {
            if (!is_numeric($weight)) {
                throw new \InvalidArgumentException("All weights must be integers or floats.");
            }
        }

        return $weights;
    }

    /**
     * Validates and normalizes the aggregation function.
     *
     * @param string|null $aggregate The aggregation function (sum, min, max).
     * @return string The normalized aggregation function.
     * @throws \InvalidArgumentException if the aggregation function is invalid.
     */
    public static function validateAndPrepareAggregate(?string $aggregate): string
    {
        // Default to sum
        if (is_null($aggregate)) {
            return self::AGGREGATE_SUM;
        }

        $aggregate = strtolower($aggregate);
        if (!in_array($aggregate, [self::AGGREGATE_SUM, self::AGGREGATE_MIN, self::AGGREGATE_MAX])) {
            throw new \InvalidArgumentException("Invalid aggregate option. Must be 'sum', 'min', or 'max'.");
        }

        return $aggregate;
    }
}
