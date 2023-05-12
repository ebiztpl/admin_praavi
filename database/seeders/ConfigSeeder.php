<?php

namespace Database\Seeders;

use App\Models\Config\Config;
use Illuminate\Database\Seeder;

class ConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $config = Config::firstOrCreate(['name' => 'system']);
        $config->value = [
            'enable_dark_theme' => false,
        ];
        $config->save();
    }
}
