<?php

namespace App\Enums\Payroll;

use App\Concerns\HasEnum;

enum SalaryStructureUnit: string
{
    use HasEnum;

    case MONTHLY = 'monthly';

    public static function translation(): string
    {
        return 'payroll.salary_structure.units.';
    }
}
