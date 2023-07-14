<?php

namespace App\Enums;

class UserRole
{
    const ADMIN = 1;
    const USER = 2;
    public static function getKey($value)
    {
        $constants = self::getConstants();
        $key = array_search($value, $constants, true);
        return $key !== false ? strtolower($key) : null;
    }

    private static function getConstants()
    {
        $reflectionClass = new \ReflectionClass(self::class);
        return $reflectionClass->getConstants();
    }
}
