<?php

namespace Momento\Cache\Utils;

/**
 * Represents a range value that can be used in sorted set operations.
 *
 * A range value can be an integer, a float, or a special value representing
 * positive or negative infinity. It can also be marked as either inclusive or exclusive.
 * This class is typically used to specify bounds for operations on sorted sets.
 */
class RangeValue
{
    /**
     * @var float|int|string $value The actual value of the range.
     * Can be a numeric value (float or int) or a string representing infinity ('+inf' or '-inf').
     */
    private float|int|string $value;

    /**
     * @var bool $inclusive Whether the range value is inclusive or exclusive.
     * True if the value is inclusive (i.e., the range includes this value).
     * False if the value is exclusive (i.e., the range does not include this value).
     */
    private bool $inclusive;

    /**
     * Represents the string for positive infinity.
     */
    const POSITIVE_INFINITY = '+inf';

    /**
     * Represents the string for negative infinity.
     */
    const NEGATIVE_INFINITY = '-inf';

    /**
     * RangeValue constructor.
     *
     * @param float|int|string $value The range value, which can be an integer, float, or one of the special values '+inf' or '-inf'.
     * @param bool $inclusive Whether the value is inclusive or exclusive.
     * If true, the value is included in the range, otherwise it is not.
     */
    public function __construct(float|int|string $value, bool $inclusive)
    {
        $this->value = $value;
        $this->inclusive = $inclusive;
    }

    /**
     * Get the value of the range.
     *
     * @return float|int|string Returns the value, which can be an integer, float, or a string ('+inf' or '-inf').
     */
    public function getValue(): float|int|string
    {
        return $this->value;
    }

    /**
     * Check if the range value is inclusive.
     *
     * @return bool True if the value is inclusive, false if it's exclusive.
     */
    public function isInclusive(): bool
    {
        return $this->inclusive;
    }

    /**
     * Check if the range value represents positive infinity.
     *
     * @return bool True if the value is '+inf', false otherwise.
     */
    public function isPositiveInfinity(): bool
    {
        return $this->value === self::POSITIVE_INFINITY;
    }

    /**
     * Check if the range value represents negative infinity.
     *
     * @return bool True if the value is '-inf', false otherwise.
     */
    public function isNegativeInfinity(): bool
    {
        return $this->value === self::NEGATIVE_INFINITY;
    }

    /**
     * Check if the range value is a finite number (not infinity).
     *
     * @return bool True if the value is finite (neither '+inf' nor '-inf'), false otherwise.
     */
    public function isFinite(): bool
    {
        return !$this->isPositiveInfinity() && !$this->isNegativeInfinity();
    }

    /**
     * Get the value if it is finite, or null if it is infinite.
     * @return float|int|null The value if it is finite, or null if it is infinite.
     */
    public function getValueIfFiniteOrNull(): float|int|null
    {
        return $this->isFinite() ? $this->value : null;
    }

    /**
     * Parse an input value to create a RangeValue object.
     *
     * The input can be an integer, float, or string. If the input is a numeric value,
     * it will be treated as an inclusive value. If the input is a string representation
     * of a number, it will also be treated as inclusive. Strings can also represent
     * infinity ('+inf' or '-inf') or exclusive bounds (e.g., '(5' means exclusive 5).
     *
     * @param float|int|string $input The input to parse. Can be:
     *   - A float or integer for inclusive numeric values.
     *   - A string representing a number, '+inf', '-inf', or an exclusive bound like '(5'.
     * @return self A RangeValue object representing the parsed input.
     * @throws \InvalidArgumentException if the input is invalid.
     */
    public static function parse(float|int|string $input): self
    {
        if (is_int($input) || is_float($input)) {
            return new self($input, true);
        }

        if (is_string($input)) {
            $lowerInput = strtolower($input);

            // Handle +inf and -inf cases
            if ($lowerInput === self::POSITIVE_INFINITY) {
                return new self(self::POSITIVE_INFINITY, false);
            } elseif ($lowerInput === self::NEGATIVE_INFINITY) {
                return new self(self::NEGATIVE_INFINITY, false);
            }

            if (is_numeric($input)) {
                // Parse a numeric string to float or int
                return new self(str_contains($input, '.') ? (float)$input : (int)$input, true);
            }

            // Handle exclusive ranges (e.g., "(5" means exclusive 5)
            if (preg_match('/^\(([-]?\d+(\.\d+)?)$/', $input, $matches)) {
                return new self(str_contains($matches[1], '.') ? (float)$matches[1] : (int)$matches[1], false);
            }
        }

        throw new \InvalidArgumentException("Invalid range value: $input");
    }
}
