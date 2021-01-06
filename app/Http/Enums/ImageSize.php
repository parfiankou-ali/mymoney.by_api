<?php

namespace App\Http\Enums;

class ImageSize extends Enum
{
    public const SQUARE_64 = '64x64';
    public const SQUARE_128 = '128x128';
    public const MAX_64 = 64;
    public const MAX_128 = 128;
    public const MAX_256 = 256;
    public const MAX_512 = 512;
    public const MAX_1024 = 1024;
    public const MAX_2048 = 2048;
    public const MAX_4096 = 4096;
    public const MAX_8192 = 8192;
    public const ORIGINAL = 'original';

    /**
     * Determine an acceptable enumeration values. It must be
     * an array of integers.
     *
     * @return array
     */
    public static function values(): array
    {
        return [
            self::MAX_64,
            self::MAX_128,
            self::MAX_256,
            self::MAX_512,
            self::MAX_1024,
            self::MAX_2048,
        ];
    }
}
