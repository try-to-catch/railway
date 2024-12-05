<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

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

        $envExamplePath = base_path('.env.example');
        $envPath = base_path('.env');

        if (File::exists($envPath)) {
            return $this->error('.env file already exists.') && self::FAILURE;
        }

        if (!File::exists($envExamplePath)) {
            return $this->error('.env.example file is missing.') && self::FAILURE;
        }

        File::copy($envExamplePath, $envPath);

        $this->call('./vendor/bin/sail', ['up', '-d']);
        $this->call('migrate');

        $this->call('key:generate');
        $this->call('storage:link');

        $this->info('Application installed successfully.');

        return self::SUCCESS;
    }
}
