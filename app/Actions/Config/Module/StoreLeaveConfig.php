<?php

namespace App\Actions\Config\Module;

class StoreLeaveConfig
{
    public static function handle(): array
    {
        $input = request()->validate([], [], []);

        return $input;
    }
}
