<?php

namespace App\Enums\Payroll;

use App\Concerns\HasEnum;
use App\Contracts\HasColor;

enum PayHeadType: string implements HasColor
{
    use HasEnum;

    case EARNING = 'earning';
    case DEDUCTION = 'deduction';

    public static function translation(): string
    {
        return 'payroll.pay_head.types.';
    }

    public function color(): string
    {
        return match ($this) {
            PayHeadType::EARNING => 'success',
            PayHeadType::DEDUCTION => 'danger',
        };
    }
}
