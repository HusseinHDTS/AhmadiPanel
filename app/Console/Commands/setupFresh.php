<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class setupFresh extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'app:setup';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Migrate and seed';

  /**
   * Execute the console command.
   */
  public function handle()
  {
    $this->info('Running migrate:fresh...');
    $this->call('migrate:fresh');

    $this->info('Running passport:install --force...');
    $this->runPassportInstall();

    $this->info('Running db:seed...');
    $this->call('db:seed');

    $this->info('Database setup completed.');
  }
  protected function runPassportInstall()
  {
    $input = $this->getOutput()->isDecorated() ? 'yes' : 'no';

    Artisan::call('passport:install', [
      '--force' => true,
      '--no-interaction' =>true,
    ]);

    // Override input prompt programmatically
    // $this->output->write('yes' . PHP_EOL);
    // $this->output->write('yes' . PHP_EOL);
  }
}
