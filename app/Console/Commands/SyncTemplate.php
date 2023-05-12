<?php

namespace App\Console\Commands;

use App\Models\Config\MailTemplate;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;

class SyncTemplate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:template';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync template';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $force = $this->option('force');

        \Artisan::call('db:seed', ['--class' => 'MailTemplateSeeder', '--force' => $force ? true : false]);

        $this->info('Template synced.');
    }
}
