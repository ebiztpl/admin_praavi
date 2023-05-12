<?php

namespace Mint\Service\Actions;

use Closure;

class SeedConfig
{
    public function handle($params, Closure $next)
    {
        \Artisan::call('db:seed', ['--class' => 'MailTemplateSeeder', '--force' => true]);

        return $next($params);
    }
}
