<?php

namespace Modules\Backup\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Support\Renderable;
use Modules\Backup\Services\BackupService;

class BackupController extends Controller
{
    protected $backupService;

    public function __construct(BackupService $backupService)
    {
        $this->backupService = $backupService;
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $backupPath = storage_path('app/backup-db');

        if (!File::exists($backupPath)) {
            File::makeDirectory($backupPath, 0755, true);
        }

        $backups = collect(File::allFiles($backupPath))
            ->filter(fn ($file) => $file->getExtension() === 'zip')
            ->sortByDesc(fn ($file) => $file->getMTime())
            ->map(function ($file) {
                return [
                    'filename' => $file->getFilename(),
                    'path' => $file->getPathname(),
                    'size' => $file->getSize(),
                    'formatted_size' => BackupService::formatBytes($file->getSize()),
                    'modified_at' => $file->getMTime(),
                    'formatted_date' => \Carbon\Carbon::createFromTimestamp($file->getMTime())->format('Y-m-d H:i:s'),
                    'download_link' => route('backup.download', ['filename' => $file->getFilename()]),
                ];
            });

        return view('backup::backend.index', compact('backups'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create(Request $request)
    {
        $filename = $request->input('filename');
        $result = $this->backupService->createDatabaseBackup($filename);

        if ($result['success']) {
            return redirect()->route('backup.index')->with('success', $result['message']);
        }

        return redirect()->route('backup.index')->with('error', $result['message']);
    }

    public function restore(string $filename)
    {
        $result = $this->backupService->restoreDatabase($filename);
        return $result['success']
            ? redirect()->route('backup.index')->with('success', $result['message'])
            : redirect()->route('backup.index')->with('error', $result['message']);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(string $filename)
    {
        $result = $this->backupService->deleteBackup($filename);
        return redirect()->route('backup.index')->with(
            $result['success'] ? 'success' : 'error',
            $result['message']
        );
    }

    public function download(string $filename)
    {
        $path = $this->backupService->getBackupFilePath($filename);

        if (!$path) {
            return redirect()->route('backup.index')->with('error', 'File tidak ditemukan.');
        }

        return response()->download($path);
    }

    // public function testExtractZip(string $filename)
    // {
    //     $zipPath = storage_path("app/backup-db/{$filename}");
    //     if (!file_exists($zipPath)) {
    //         return redirect()->route('backup.index')->with('error', 'File ZIP tidak ditemukan.');
    //     }

    //     $folderName = pathinfo($filename, PATHINFO_FILENAME); // ambil namafilenya saja tanpa ekstensi .sql
    //     $extractPath = storage_path("app/backup-db/{$folderName}");

    //     // Hapus jika sudah ada
    //     if (File::exists($extractPath)) {
    //         File::deleteDirectory($extractPath);
    //     }
    //     File::makeDirectory($extractPath, 0755, true);

    //     // Ekstrak ZIP
    //     $zip = new \ZipArchive;
    //     if ($zip->open($zipPath) !== TRUE) {
    //         return redirect()->route('backup.index')->with('error', 'Gagal membuka file ZIP.');
    //     }

    //     if (!$zip->extractTo($extractPath)) {
    //         $zip->close();
    //         return redirect()->route('backup.index')->with('error', 'Gagal mengekstrak file ZIP.');
    //     }
    //     $zip->close();

    //     // Pindahkan isinya keluar dari folder db-dumps
    //     $subFolder = "{$extractPath}/db-dumps";
    //     if (File::isDirectory($subFolder)) {
    //         $files = File::allFiles($subFolder);
    //         foreach ($files as $file) {
    //             $newPath = "{$extractPath}/" . $file->getFilename();
    //             File::move($file->getPathname(), $newPath);
    //         }

    //         // Hapus folder db-dumps kosong
    //         File::deleteDirectory($subFolder);
    //     }

    //     return redirect()->route('backup.index')->with('success', 'File berhasil diekstrak.');
    // }

    // public function testExtractZip(string $filename)
    // {
    //     $zipPath = storage_path("app/backup-db/{$filename}");
    //     if (!file_exists($zipPath)) {
    //         return redirect()->route('backup.index')->with('error', 'File ZIP tidak ditemukan.');
    //     }

    //     $folderName = pathinfo($filename, PATHINFO_FILENAME);
    //     $extractPath = storage_path("app/backup-db/{$folderName}");

    //     // Hapus jika sudah ada
    //     if (File::exists($extractPath)) {
    //         File::deleteDirectory($extractPath);
    //     }
    //     File::makeDirectory($extractPath, 0755, true);

    //     // Ekstrak ZIP
    //     $zip = new \ZipArchive;
    //     if ($zip->open($zipPath) !== TRUE) {
    //         return redirect()->route('backup.index')->with('error', 'Gagal membuka file ZIP.');
    //     }

    //     if (!$zip->extractTo($extractPath)) {
    //         $zip->close();
    //         return redirect()->route('backup.index')->with('error', 'Gagal mengekstrak file ZIP.');
    //     }
    //     $zip->close();

    //     // Pindahkan file dari db-dumps ke root extractPath
    //     $subFolder = "{$extractPath}/db-dumps";
    //     if (File::isDirectory($subFolder)) {
    //         $files = File::allFiles($subFolder);
    //         foreach ($files as $file) {
    //             $newPath = "{$extractPath}/" . $file->getFilename();
    //             File::move($file->getPathname(), $newPath);
    //         }

    //         File::deleteDirectory($subFolder);
    //     }

    //     // Cari file .sql hasil ekstraksi
    //     $sqlFile = collect(File::allFiles($extractPath))->first(fn ($f) => $f->getExtension() === 'sql');

    //     if (!$sqlFile) {
    //         return redirect()->route('backup.index')->with('error', 'Tidak ada file SQL ditemukan setelah ekstraksi.');
    //     }

    //     // Dapatkan path mysql CLI
    //     $mysqlPath = $this->getMySqlClientPath();
    //     $sqlFilePath = $sqlFile->getPathname();

    //     // Konfigurasi database
    //     $db = config('database.connections.mysql');

    //     // Jalankan perintah restore
    //     $command = [
    //         $mysqlPath,
    //         '--host=' . $db['host'],
    //         '--port=' . $db['port'],
    //         '--user=' . $db['username'],
    //         '--password=' . $db['password'],
    //         $db['database'],
    //         '<',
    //         escapeshellarg($sqlFilePath)
    //     ];

    //     try {
    //         set_time_limit(0); // disable time limit
    //         $process = new \Symfony\Component\Process\Process($command);
    //         $process->setTimeout(3600); // timeout 1 jam
    //         $process->run();

    //         if (!$process->isSuccessful()) {
    //             throw new \Symfony\Component\Process\Exception\ProcessFailedException($process);
    //         }

    //         // Hapus folder ekstraksi setelah restore (opsional)
    //         File::deleteDirectory($extractPath);

    //         return redirect()->route('backup.index')->with('success', 'Database berhasil direstore.');
    //     } catch (\Exception $e) {
    //         Log::error('Restore Gagal', [
    //             'message' => $e->getMessage(),
    //             'output' => $process->getErrorOutput() ?: $process->getOutput()
    //         ]);

    //         return redirect()->route('backup.index')->with('error', 'Restore gagal: ' . $e->getMessage());
    //     }
    // }

    // /**
    //  * Dapatkan path ke mysql.exe
    //  *
    //  * @return string
    //  * @throws \Exception
    //  */
    // protected function getMySqlClientPath(): string
    // {
    //     $commonPaths = [
    //         'C:\laragon\bin\mysql\mysql-8.0.30-winx64\bin\mysql.exe',
    //         'C:\xampp\mysql\bin\mysql.exe',
    //         '/usr/bin/mysql',
    //         '/usr/local/bin/mysql',
    //         '/bin/mysql',
    //         '/usr/local/mysql/bin/mysql'
    //     ];

    //     foreach ($commonPaths as $path) {
    //         if (is_executable($path)) {
    //             return $path;
    //         }
    //     }

    //     throw new \Exception("mysql CLI client tidak ditemukan. Silakan cek instalasi MySQL.");
    // }
}
