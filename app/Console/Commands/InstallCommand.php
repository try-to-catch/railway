<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the application';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Installing the application...');

        $this->call('key:generate');
        $this->call('storage:link');
        $this->call('migrate');

        $this->info('Application installed successfully.');

        return self::SUCCESS;
    }
}
