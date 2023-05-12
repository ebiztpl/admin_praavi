<?php

namespace App\Enums\Attendance;

use App\Concerns\HasEnum;

enum ProductionUnit: string
{
    use HasEnum;

    case HOURLY = 'hourly';

    public static function translation(): string
    {
        return 'attendance.production_units.';
    }
}
