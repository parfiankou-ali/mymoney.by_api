<?php

namespace App\Http\Enums;

class UserRole extends Enum
{
    public const OWNER = 20;
    public const STOCK_ADMINISTRATOR = 10;
    public const TRADER = 5;

    /**
     * Determine an acceptable enumeration values. It must be
     * an array of integers.
     *
     * @return array
     */
    public static function values(): array
    {
        return [
            self::OWNER,
            self::STOCK_ADMINISTRATOR,
            self::TRADER,
        ];
    }

    public static function hasPermissions(int $actual, int $expected): bool
    {
        return $actual >= $expected;
    }

    public static function canManageStock(int $role)
    {
        return self::hasPermissions($role, self::STOCK_ADMINISTRATOR);
    }

    public static function canSellProducts(int $role)
    {
        return self::hasPermissions($role, self::TRADER);
    }
}
