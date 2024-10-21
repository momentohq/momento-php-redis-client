<?php

namespace Momento\Cache\Utils;

/**
 * Represents a range value.
 *
 * A range value is a value that can be used to represent a range in a sorted set.
 * It can be either inclusive or exclusive.
 */
class RangeValue
{
    private int $value;
    private bool $inclusive;

    public function __construct(int $value, bool $inclusive)
    {
        $this->value = $value;
        $this->inclusive = $inclusive;
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function isInclusive(): bool
    {
        return $this->inclusive;
    }

    public static function parse(int|string $input): self
    {
        if (is_int($input)) {
            return new self($input, true);
        }

        if (is_string($input)) {
            if (is_numeric($input)) {
                return new self((int)$input, true);
            }

            if (preg_match('/^\((-?\d+)$/', $input, $matches)) {
                return new self((int)$matches[1], false);
            }
        }

        throw new \InvalidArgumentException("Invalid range value: $input");
    }
}
