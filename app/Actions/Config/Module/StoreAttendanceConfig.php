<?php

namespace App\Actions\Config\Module;

class StoreAttendanceConfig
{
    public static function handle(): array
    {
        $input = request()->validate([
            'allow_employee_clock_in_out' => 'sometimes|boolean',
            'allow_employee_clock_in_out_via_device' => 'sometimes|boolean',
        ], [], []);

        return $input;
    }
}
