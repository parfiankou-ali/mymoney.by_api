<?php

namespace App\Http\Enums;

abstract class Enum
{
    /**
     * Determine an acceptable enumeration values. It must be
     * an array of integers.
     *
     * @return array
     */
    abstract public static function values(): array;

    /**
     * Return a minimum available value.
     *
     * @return int
     */
    public static function min(): int
    {
        return min(static::values());
    }
}
