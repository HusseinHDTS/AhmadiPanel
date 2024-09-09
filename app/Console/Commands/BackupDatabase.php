<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class BackupDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backup:database';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command Database Backup';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $databaseName = env('DB_DATABASE');
        $backupFile = storage_path('app/backup-' . date('Y-m-d_H-i-s') . '.sql');
        $command = "mysqldump --user=" . env('DB_USERNAME') . " --password=" . env('DB_PASSWORD') . " $databaseName > $backupFile";
        
        exec($command);

        $this->info('Backup created at ' . $backupFile);
    }
}
