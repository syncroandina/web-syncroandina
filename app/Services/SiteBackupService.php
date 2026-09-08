<?php
namespace App\Services;

use PDO;
use PDOException;

class SiteBackupService {

    public static function getPHPUploadLimits() {
        return [
            'upload_max_filesize' => ini_get('upload_max_filesize'),
            'post_max_size' => ini_get('post_max_size')
        ];
    }

    public static function generateBackupZip() {
        @ini_set('memory_limit', '512M');
        @set_time_limit(0);

        $dbConfigPath = __DIR__ . '/../../config/database.php';
        if (!file_exists($dbConfigPath)) {
            throw new \Exception('No se encontró el archivo de configuración de base de datos.');
        }

        $config = require $dbConfigPath;
        $portStr = !empty($config['port']) ? ";port={$config['port']}" : "";

        $pdo = new PDO(
            "mysql:host={$config['host']}{$portStr};dbname={$config['dbname']};charset={$config['charset']}",
            $config['username'],
            $config['password'],
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]
        );

        $tables = [];
        $stmt = $pdo->query("SHOW TABLES");
        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $tables[] = $row[0];
        }

        $sqlDump = "-- =========================================================\n";
        $sqlDump .= "-- Backup de Base de Datos MySQL - CMS Respaldo Completo\n";
        $sqlDump .= "-- Fecha de Generación: " . date('Y-m-d H:i:s') . "\n";
        $sqlDump .= "-- Base de Datos: {$config['dbname']}\n";
        $sqlDump .= "-- =========================================================\n\n";
        $sqlDump .= "SET FOREIGN_KEY_CHECKS=0;\n";
        $sqlDump .= "SET SQL_MODE = \"NO_AUTO_VALUE_ON_ZERO\";\n";
        $sqlDump .= "SET time_zone = \"+00:00\";\n\n";

        foreach ($tables as $table) {
            $sqlDump .= "-- --------------------------------------------------------\n";
            $sqlDump .= "-- Estructura de tabla para `{$table}`\n";
            $sqlDump .= "-- --------------------------------------------------------\n";
            $sqlDump .= "DROP TABLE IF EXISTS `{$table}`;\n";

            $createStmt = $pdo->query("SHOW CREATE TABLE `{$table}`");
            $createRow = $createStmt->fetch(PDO::FETCH_NUM);
            $sqlDump .= $createRow[1] . ";\n\n";

            $rowsStmt = $pdo->query("SELECT * FROM `{$table}`");
            $rows = $rowsStmt->fetchAll();

            if (count($rows) > 0) {
                $sqlDump .= "-- Volcado de datos para la tabla `{$table}`\n";
                $columns = array_keys($rows[0]);
                $quotedColumns = array_map(function($c) { return "`{$c}`"; }, $columns);
                $colsSql = implode(', ', $quotedColumns);

                foreach ($rows as $row) {
                    $values = [];
                    foreach ($row as $val) {
                        if ($val === null) {
                            $values[] = "NULL";
                        } else {
                            $values[] = $pdo->quote($val);
                        }
                    }
                    $valsSql = implode(', ', $values);
                    $sqlDump .= "INSERT INTO `{$table}` ({$colsSql}) VALUES ({$valsSql});\n";
                }
                $sqlDump .= "\n";
            }
        }

        $sqlDump .= "SET FOREIGN_KEY_CHECKS=1;\n";

        $tempDir = __DIR__ . '/../../storage/temp_export';
        if (!file_exists($tempDir)) {
            @mkdir($tempDir, 0755, true);
        }

        $timestamp = date('Ymd_His');
        $zipFilename = "site_backup_{$timestamp}.zip";
        $zipPath = $tempDir . '/' . $zipFilename;

        $manifest = [
            'cms' => 'SyncroAndina CMS',
            'version' => '1.0.0',
            'created_at' => date('Y-m-d H:i:s'),
            'tables_count' => count($tables)
        ];

        $zipCreated = false;

        if (class_exists('\ZipArchive')) {
            $zip = new \ZipArchive();
            if ($zip->open($zipPath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) === true) {
                $zip->addFromString('database_backup.sql', $sqlDump);
                $zip->addFromString('backup_manifest.json', json_encode($manifest, JSON_PRETTY_PRINT));

                $uploadsDir = realpath(__DIR__ . '/../../public/uploads');
                if ($uploadsDir && is_dir($uploadsDir)) {
                    $iterator = new \RecursiveIteratorIterator(
                        new \RecursiveDirectoryIterator($uploadsDir, \RecursiveDirectoryIterator::SKIP_DOTS),
                        \RecursiveIteratorIterator::SELF_FIRST
                    );

                    foreach ($iterator as $file) {
                        $filePath = $file->getRealPath() ?: $file->getPathname();
                        $normFile = str_replace('\\', '/', $filePath);
                        $normUploads = str_replace('\\', '/', $uploadsDir);

                        if (str_starts_with(strtolower($normFile), strtolower($normUploads))) {
                            $relPath = 'uploads/' . ltrim(substr($normFile, strlen($normUploads)), '/');
                        } else {
                            $relPath = 'uploads/' . $file->getFilename();
                        }

                        if ($file->isDir()) {
                            $zip->addEmptyDir($relPath);
                        } else if ($file->isFile()) {
                            $zip->addFile($filePath, $relPath);
                        }
                    }
                } else {
                    $zip->addEmptyDir('uploads');
                }

                $zip->close();
                $zipCreated = true;
            }
        }

        if (!$zipCreated) {
            // Fallback con PowerShell / Tar / Temp
            $rawDir = $tempDir . '/raw_' . time();
            @mkdir($rawDir, 0755, true);
            file_put_contents($rawDir . '/database_backup.sql', $sqlDump);
            file_put_contents($rawDir . '/backup_manifest.json', json_encode($manifest, JSON_PRETTY_PRINT));

            $uploadsDir = realpath(__DIR__ . '/../../public/uploads');
            if ($uploadsDir && is_dir($uploadsDir)) {
                @mkdir($rawDir . '/uploads', 0755, true);
                $iterator = new \RecursiveIteratorIterator(
                    new \RecursiveDirectoryIterator($uploadsDir, \RecursiveDirectoryIterator::SKIP_DOTS),
                    \RecursiveIteratorIterator::SELF_FIRST
                );
                foreach ($iterator as $file) {
                    $filePath = $file->getRealPath() ?: $file->getPathname();
                    $normFile = str_replace('\\', '/', $filePath);
                    $normUploads = str_replace('\\', '/', $uploadsDir);

                    if (str_starts_with(strtolower($normFile), strtolower($normUploads))) {
                        $relPath = 'uploads/' . ltrim(substr($normFile, strlen($normUploads)), '/');
                    } else {
                        $relPath = 'uploads/' . $file->getFilename();
                    }

                    $targetPath = $rawDir . '/' . $relPath;
                    if ($file->isDir()) {
                        @mkdir($targetPath, 0755, true);
                    } else if ($file->isFile()) {
                        @copy($filePath, $targetPath);
                    }
                }
            }

            if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
                $zipWin = str_replace('/', '\\', $zipPath);
                $rawWin = str_replace('/', '\\', $rawDir);
                $cmd = 'powershell -NoProfile -ExecutionPolicy Bypass -Command "Compress-Archive -Path \'' . $rawWin . '\*\' -DestinationPath \'' . $zipWin . '\' -Force"';
                @exec($cmd, $out, $ret);
                if ($ret === 0 && file_exists($zipPath)) {
                    $zipCreated = true;
                }
            }

            self::deleteDir($rawDir);
        }

        if (!$zipCreated || !file_exists($zipPath)) {
            throw new \Exception('No se pudo crear el paquete comprimido de exportación del sitio.');
        }

        return $zipPath;
    }

    public static function restoreBackupZip($zipFilePath) {
        @ini_set('memory_limit', '512M');
        @set_time_limit(0);

        $tempExtractDir = __DIR__ . '/../../storage/temp_import/' . time();
        if (!file_exists($tempExtractDir)) {
            @mkdir($tempExtractDir, 0755, true);
        }

        $stagedZipPath = $tempExtractDir . '/package.zip';
        if (!@copy($zipFilePath, $stagedZipPath)) {
            $stagedZipPath = $zipFilePath;
        }

        $extractSuccess = false;

        if (class_exists('\ZipArchive')) {
            $zip = new \ZipArchive();
            if ($zip->open($stagedZipPath) === true) {
                $zip->extractTo($tempExtractDir);
                $zip->close();
                $extractSuccess = true;
            }
        }

        if (!$extractSuccess) {
            if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
                $zipWin = str_replace('/', '\\', realpath($stagedZipPath) ?: $stagedZipPath);
                $extWin = str_replace('/', '\\', realpath($tempExtractDir) ?: $tempExtractDir);
                $cmd = 'powershell -NoProfile -ExecutionPolicy Bypass -Command "Expand-Archive -Path \'' . $zipWin . '\' -DestinationPath \'' . $extWin . '\' -Force"';
                @exec($cmd, $out, $ret);
                if ($ret === 0) $extractSuccess = true;
            }
        }

        if (!$extractSuccess) {
            throw new \Exception('No se pudo descomprimir el archivo de respaldo proporcionado.');
        }

        $sqlPath = $tempExtractDir . '/database_backup.sql';
        if (!file_exists($sqlPath)) {
            $sqls = glob($tempExtractDir . '/*/database_backup.sql');
            if (!empty($sqls)) {
                $sqlPath = $sqls[0];
            }
        }

        if (!file_exists($sqlPath)) {
            throw new \Exception('El archivo ZIP no contiene una base de datos válida (database_backup.sql no encontrado).');
        }

        $dbConfigPath = __DIR__ . '/../../config/database.php';
        if (!file_exists($dbConfigPath)) {
            throw new \Exception('Configuración de base de datos no encontrada.');
        }

        $config = require $dbConfigPath;
        $portStr = !empty($config['port']) ? ";port={$config['port']}" : "";

        $pdo = new PDO(
            "mysql:host={$config['host']}{$portStr};dbname={$config['dbname']};charset={$config['charset']}",
            $config['username'],
            $config['password'],
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => true
            ]
        );

        $sqlContent = file_get_contents($sqlPath);
        try {
            $pdo->exec($sqlContent);
        } catch (\PDOException $e) {
            $queries = preg_split('/;\s*[\r\n]+/', $sqlContent);
            foreach ($queries as $query) {
                $trimmed = trim($query);
                if (!empty($trimmed)) {
                    $pdo->exec($trimmed);
                }
            }
        }

        $sourceUploads = $tempExtractDir . '/uploads';
        if (!is_dir($sourceUploads)) {
            $subUploads = glob($tempExtractDir . '/*/uploads', GLOB_ONLYDIR);
            if (!empty($subUploads)) {
                $sourceUploads = $subUploads[0];
            }
        }

        if (is_dir($sourceUploads)) {
            $targetUploads = __DIR__ . '/../../public/uploads';
            if (!is_dir($targetUploads)) {
                @mkdir($targetUploads, 0755, true);
            }

            $iterator = new \RecursiveIteratorIterator(
                new \RecursiveDirectoryIterator($sourceUploads, \RecursiveDirectoryIterator::SKIP_DOTS),
                \RecursiveIteratorIterator::SELF_FIRST
            );

            foreach ($iterator as $item) {
                $src = str_replace('\\', '/', $item->getRealPath() ?: $item->getPathname());
                $normSourceUploads = str_replace('\\', '/', $sourceUploads);

                if (str_starts_with(strtolower($src), strtolower($normSourceUploads))) {
                    $rel = ltrim(substr($src, strlen($normSourceUploads)), '/');
                } else {
                    $rel = $item->getFilename();
                }
                $dst = $targetUploads . '/' . $rel;

                if ($item->isDir()) {
                    if (!file_exists($dst)) @mkdir($dst, 0755, true);
                } else {
                    $dstDir = dirname($dst);
                    if (!file_exists($dstDir)) @mkdir($dstDir, 0755, true);
                    @copy($src, $dst);
                }
            }
        }

        self::deleteDir($tempExtractDir);

        return true;
    }

    private static function deleteDir($dir) {
        if (!file_exists($dir)) return true;
        if (!is_dir($dir)) return unlink($dir);
        foreach (scandir($dir) as $item) {
            if ($item == '.' || $item == '..') continue;
            if (!self::deleteDir($dir . DIRECTORY_SEPARATOR . $item)) return false;
        }
        return rmdir($dir);
    }
}
