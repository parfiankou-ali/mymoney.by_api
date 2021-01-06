<?php

namespace App\Http\Enums;

class Gender extends Enum
{
    public const MALE = 1;
    public const FEMALE = 2;

    /**
     * Determine an acceptable enumeration values. It must be
     * an array of integers.
     *
     * @return array
     */
    public static function values(): array
    {
        return [
            self::MALE,
            self::FEMALE,
        ];
    }
}
