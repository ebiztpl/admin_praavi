<?php

namespace App\Actions\Config\Module;

class StorePayrollConfig
{
    public static function handle(): array
    {
        $input = request()->validate([
            'code_number_prefix' => 'sometimes|max:100',
            'code_number_digit' => 'sometimes|required|integer|min:0|max:9',
            'code_number_suffix' => 'sometimes|max:100',
        ], [
            'code_number_prefix' => __('payroll.config.props.number_prefix'),
            'code_number_digit' => __('payroll.config.props.number_digit'),
            'code_number_suffix' => __('payroll.config.props.number_suffix'),
        ], []);

        return $input;
    }
}
