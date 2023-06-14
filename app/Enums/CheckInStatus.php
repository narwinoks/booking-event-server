<?php

namespace App\Enums;

enum CheckInStatus
{
    const CHECKIN = 1;
    const NOT_CHECKIN = 0;

    public static function getValues(): array
    {
        return [self::NOT_CHECKIN, self::CHECKIN];
    }
}
