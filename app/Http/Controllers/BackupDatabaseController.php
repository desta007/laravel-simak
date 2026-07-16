<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use RealRashid\SweetAlert\Facades\Alert;

class BackupDatabaseController extends Controller
{
    /**
     * Folder penyimpanan file backup (storage/app/backups).
     */
    private function backupPath(): string
    {
        $path = storage_path('app/backups');
        if (!File::isDirectory($path)) {
            File::makeDirectory($path, 0755, true);
        }
        return $path;
    }

    /**
     * Pastikan hanya admin (id_group_user == 1) yang boleh mengakses fitur ini.
     */
    private function authorizeAdmin(): void
    {
        if (auth()->user()->id_group_user != 1) {
            abort(403, 'Anda tidak memiliki akses ke fitur ini.');
        }
    }

    public function index()
    {
        $this->authorizeAdmin();

        $files = collect(File::files($this->backupPath()))
            ->filter(fn ($file) => strtolower($file->getExtension()) === 'sql')
            ->map(fn ($file) => [
                'name' => $file->getFilename(),
                'size' => $file->getSize(),
                'created_at' => $file->getMTime(),
            ])
            ->sortByDesc('created_at')
            ->values();

        $title = 'Hapus File Backup!';
        $text = "Apakah anda yakin akan menghapus file backup ini?";
        confirmDelete($title, $text);

        return view('backup.index', [
            'files' => $files,
            'database' => config('database.connections.' . config('database.default') . '.database'),
        ]);
    }

    /**
     * Buat file backup SQL baru dari seluruh isi database.
     */
    public function store(Request $request)
    {
        $this->authorizeAdmin();

        try {
            $database = config('database.connections.' . config('database.default') . '.database');
            $fileName = 'backup_' . $database . '_' . date('Ymd_His') . '.sql';
            $fullPath = $this->backupPath() . DIRECTORY_SEPARATOR . $fileName;

            $this->generateDump($fullPath, $database);

            Alert::success('Berhasil', 'Backup database berhasil dibuat: ' . $fileName);
        } catch (\Throwable $e) {
            Alert::error('Gagal', 'Backup database gagal dibuat: ' . $e->getMessage());
        }

        return redirect()->route('backupDatabase.index');
    }

    /**
     * Download file backup.
     */
    public function download($file)
    {
        $this->authorizeAdmin();

        $safeName = basename($file);
        $fullPath = $this->backupPath() . DIRECTORY_SEPARATOR . $safeName;

        if (!File::exists($fullPath) || strtolower(pathinfo($safeName, PATHINFO_EXTENSION)) !== 'sql') {
            abort(404, 'File backup tidak ditemukan.');
        }

        return response()->download($fullPath, $safeName, [
            'Content-Type' => 'application/sql',
        ]);
    }

    /**
     * Hapus file backup.
     */
    public function destroy($file)
    {
        $this->authorizeAdmin();

        $safeName = basename($file);
        $fullPath = $this->backupPath() . DIRECTORY_SEPARATOR . $safeName;

        if (File::exists($fullPath) && strtolower(pathinfo($safeName, PATHINFO_EXTENSION)) === 'sql') {
            File::delete($fullPath);
            Alert::success('Berhasil', 'File backup berhasil dihapus.');
        } else {
            Alert::error('Gagal', 'File backup tidak ditemukan.');
        }

        return redirect()->route('backupDatabase.index');
    }

    /**
     * Generate dump SQL murni menggunakan PHP (tanpa binary mysqldump),
     * sehingga tetap berjalan di lingkungan XAMPP/Windows tanpa konfigurasi PATH.
     */
    private function generateDump(string $fullPath, string $database): void
    {
        $pdo = DB::connection()->getPdo();
        $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

        $handle = fopen($fullPath, 'w');
        if ($handle === false) {
            throw new \RuntimeException('Tidak dapat menulis file backup.');
        }

        try {
            // Header
            fwrite($handle, "-- SIMAK Database Backup\n");
            fwrite($handle, "-- Database: {$database}\n");
            fwrite($handle, "-- Tanggal  : " . date('Y-m-d H:i:s') . "\n");
            fwrite($handle, "-- --------------------------------------------------------\n\n");
            fwrite($handle, "SET FOREIGN_KEY_CHECKS=0;\n");
            fwrite($handle, "SET SQL_MODE=\"NO_AUTO_VALUE_ON_ZERO\";\n");
            fwrite($handle, "SET time_zone = \"+00:00\";\n\n");

            $tables = $pdo->query('SHOW TABLES')->fetchAll(\PDO::FETCH_COLUMN);

            foreach ($tables as $table) {
                // Struktur tabel
                fwrite($handle, "-- --------------------------------------------------------\n");
                fwrite($handle, "-- Struktur tabel `{$table}`\n");
                fwrite($handle, "-- --------------------------------------------------------\n\n");
                fwrite($handle, "DROP TABLE IF EXISTS `{$table}`;\n");

                $createRow = $pdo->query("SHOW CREATE TABLE `{$table}`")->fetch(\PDO::FETCH_ASSOC);
                $createSql = $createRow['Create Table'] ?? ($createRow['Create View'] ?? null);
                if ($createSql !== null) {
                    fwrite($handle, $createSql . ";\n\n");
                }

                // Data tabel (dibaca per-baris agar hemat memori)
                $stmt = $pdo->query("SELECT * FROM `{$table}`");
                $columns = null;
                $rowBuffer = [];
                $bufferCount = 0;

                while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
                    if ($columns === null) {
                        $columns = array_map(fn ($c) => "`{$c}`", array_keys($row));
                        fwrite($handle, "-- Data untuk tabel `{$table}`\n");
                    }

                    $values = array_map(function ($value) use ($pdo) {
                        if ($value === null) {
                            return 'NULL';
                        }
                        return $pdo->quote((string) $value);
                    }, array_values($row));

                    $rowBuffer[] = '(' . implode(', ', $values) . ')';
                    $bufferCount++;

                    // Flush setiap 200 baris menjadi satu statement INSERT
                    if ($bufferCount >= 200) {
                        fwrite($handle, "INSERT INTO `{$table}` (" . implode(', ', $columns) . ") VALUES\n"
                            . implode(",\n", $rowBuffer) . ";\n");
                        $rowBuffer = [];
                        $bufferCount = 0;
                    }
                }

                if (!empty($rowBuffer)) {
                    fwrite($handle, "INSERT INTO `{$table}` (" . implode(', ', $columns) . ") VALUES\n"
                        . implode(",\n", $rowBuffer) . ";\n");
                }

                fwrite($handle, "\n");
            }

            fwrite($handle, "SET FOREIGN_KEY_CHECKS=1;\n");
        } finally {
            fclose($handle);
        }
    }
}
