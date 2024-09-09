<?php

namespace App\Http\Controllers;

use App\Models\Backup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class BackupController extends Controller
{
    public function download($id){
        $backup = Backup::findOrFail($id);
        $filePath = $backup->path;
        if (file_exists($filePath)) {
            // Set headers to download the file
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . basename($filePath) . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($filePath));
            
            readfile($filePath);
            return redirect()->back();
        } else {
            return redirect()->back();
        }
    }

    public function createBackup()
    {
        try {
            Artisan::call('backup:database');
            $output = Artisan::output();
            $pattern = '/\/[^\s]+/';
            if (preg_match($pattern, $output, $matches)) {
                $filePath = $matches[0];
                Backup::create([
                    'path' => $filePath,
                    'status' => 'success',
                ]);
            }
            return redirect()->back()->with('success', 'Backup created successfully!');
        } catch (\Exception $e) {
            Backup::create([
                'path' => "",
                'status' => 'failed',
            ]);

            return redirect()->back()->with('error', 'Backup failed: ' . $e->getMessage());
        }
    }

    public function list()
    {
        $backups = Backup::all();
        return response()->json([
            'data' => $backups->map(function ($backup) {
                return $backup;
            }),
        ]);
    }

    public function restoreBackup(Request $request)
    {
        $backupFile = $request->input('backup_file');
        if (!$backupFile) {
            return redirect()->back()->with('error', 'No backup file selected!');
        }
        try {
            $path = storage_path('app/backups/' . $backupFile);
            $process = new Process(['mysql', '--user=' . env('DB_USERNAME'), '--password=' . env('DB_PASSWORD'), '--database=' . env('DB_DATABASE')], null, null, file_get_contents($path));
            $process->run();
            if (!$process->isSuccessful()) {
                throw new ProcessFailedException($process);
            }
            return redirect()->back()->with('success', 'Backup restored successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to restore backup: ' . $e->getMessage());
        }
    }

    public function index()
    {
        $backups = Backup::all();
        return view('content.apps.app-backup-list', compact('backups'));
    }

}