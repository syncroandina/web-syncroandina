<?php
namespace App\Services;

use App\Models\Setting;
use PDO;

class GitHubUpdaterService {

    public static function getSettings() {
        $defaultConfig = [];
        $configFile = __DIR__ . '/../../config/updater.php';
        if (file_exists($configFile)) {
            $defaultConfig = require $configFile;
        }

        $settingModel = new Setting();
        $settings = $settingModel->getAll();

        return [
            'owner' => !empty($settings['github_repo_owner']) ? $settings['github_repo_owner'] : ($defaultConfig['owner'] ?? 'syncroandina'),
            'repo' => !empty($settings['github_repo_name']) ? $settings['github_repo_name'] : ($defaultConfig['repo'] ?? 'web-syncroandina'),
            'branch' => !empty($settings['github_branch']) ? $settings['github_branch'] : ($defaultConfig['branch'] ?? 'main'),
            'token' => !empty($settings['github_token']) ? $settings['github_token'] : ($defaultConfig['token'] ?? ''),
            'secret' => !empty($settings['github_webhook_secret']) ? $settings['github_webhook_secret'] : ($defaultConfig['secret'] ?? '')
        ];
    }

    public static function getLocalVersionInfo() {
        $versionFile = __DIR__ . '/../../storage/version.json';
        if (file_exists($versionFile)) {
            $data = json_decode(file_get_contents($versionFile), true);
            if ($data) return $data;
        }
        return [
            'version' => '1.0.0',
            'commit_hash' => 'initial',
            'updated_at' => date('Y-m-d H:i:s')
        ];
    }

    public static function checkRemoteUpdate() {
        $config = self::getSettings();
        if (empty($config['owner']) || empty($config['repo'])) {
            return [
                'success' => false,
                'message' => 'Configura el propietario y nombre del repositorio de GitHub en el panel.'
            ];
        }

        $branch = !empty($config['branch']) ? $config['branch'] : 'main';
        $url = "https://api.github.com/repos/{$config['owner']}/{$config['repo']}/commits/{$branch}";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, 'SyncroAndina-CMS-Updater');
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $headers = ['Accept: application/vnd.github.v3+json'];
        if (!empty($config['token'])) {
            $headers[] = "Authorization: Bearer {$config['token']}";
        }
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error || $httpCode !== 200) {
            return [
                'success' => false,
                'message' => "Error de conexión con GitHub (Código {$httpCode}): " . ($error ?: 'Verifica el repositorio o token.')
            ];
        }

        $data = json_decode($response, true);
        if (!$data || !isset($data['sha'])) {
            return [
                'success' => false,
                'message' => 'Respuesta inválida desde GitHub.'
            ];
        }

        $remoteSha = $data['sha'];
        $commitMessage = $data['commit']['message'] ?? '';
        $commitAuthor = $data['commit']['author']['name'] ?? '';
        $commitDate = $data['commit']['author']['date'] ?? '';

        $local = self::getLocalVersionInfo();
        $hasUpdate = ($local['commit_hash'] !== $remoteSha);

        return [
            'success' => true,
            'has_update' => $hasUpdate,
            'local_commit' => $local['commit_hash'],
            'remote_commit' => $remoteSha,
            'commit_short' => substr($remoteSha, 0, 7),
            'commit_message' => $commitMessage,
            'commit_author' => $commitAuthor,
            'commit_date' => $commitDate
        ];
    }

    public static function performUpdate() {
        @ini_set('memory_limit', '512M');
        @set_time_limit(300);

        $log = [];
        $log[] = "[" . date('Y-m-d H:i:s') . "] 🚀 Iniciando proceso de actualización desde GitHub...";

        $config = self::getSettings();
        if (empty($config['owner']) || empty($config['repo'])) {
            return [
                'success' => false,
                'message' => 'Configuración de GitHub incompleta.',
                'log' => $log
            ];
        }

        $branch = !empty($config['branch']) ? $config['branch'] : 'main';
        $zipUrls = [
            "https://api.github.com/repos/{$config['owner']}/{$config['repo']}/zipball/{$branch}",
            "https://github.com/{$config['owner']}/{$config['repo']}/archive/refs/heads/{$branch}.zip"
        ];

        $log[] = "[" . date('Y-m-d H:i:s') . "] 📥 Descargando paquete de actualización (rama '{$branch}')...";

        $tempDir = __DIR__ . '/../../storage/temp_update';
        if (!file_exists($tempDir)) {
            @mkdir($tempDir, 0755, true);
        }

        $zipPath = $tempDir . '/update.zip';
        $downloadSuccess = false;

        foreach ($zipUrls as $url) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_USERAGENT, 'SyncroAndina-CMS-Updater');
            curl_setopt($ch, CURLOPT_TIMEOUT, 60);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

            $headers = ['Accept: application/vnd.github.v3+json'];
            if (!empty($config['token'])) {
                $headers[] = "Authorization: Bearer {$config['token']}";
            }
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            $fileData = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($httpCode === 200 && !empty($fileData)) {
                file_put_contents($zipPath, $fileData);
                $downloadSuccess = true;
                $log[] = "[" . date('Y-m-d H:i:s') . "] 📦 Paquete ZIP descargado exitosamente (" . round(strlen($fileData) / 1024 / 1024, 2) . " MB).";
                break;
            }
        }

        if (!$downloadSuccess || !file_exists($zipPath)) {
            $log[] = "[" . date('Y-m-d H:i:s') . "] ❌ Error al descargar el archivo ZIP del repositorio.";
            return ['success' => false, 'message' => 'No se pudo descargar el repositorio desde GitHub.', 'log' => $log];
        }

        $extractDir = $tempDir . '/extracted';
        if (!self::extractZipFile($zipPath, $extractDir, $log)) {
            $log[] = "[" . date('Y-m-d H:i:s') . "] ❌ Error al descomprimir el archivo comprimido ZIP.";
            return ['success' => false, 'message' => 'No se pudo descomprimir el archivo de actualización. Por favor habilita la extensión "zip" en tu php.ini.', 'log' => $log];
        }

        // Encontrar la carpeta raíz dentro del Zip descompreso de GitHub (ej: usuario-repo-hash)
        $subDirs = glob($extractDir . '/*', GLOB_ONLYDIR);
        $sourceRoot = !empty($subDirs) ? $subDirs[0] : $extractDir;

        $log[] = "[" . date('Y-m-d H:i:s') . "] 📂 Extraído correctamente. Aplicando archivos al servidor...";

        $rootDir = realpath(__DIR__ . '/../../');

        // Exclusiones críticas que NUNCA deben sobrescribirse
        $excludedPaths = [
            'config/database.php',
            'storage/installed.lock',
            'public/uploads',
            'storage/temp_update',
            'dist',
            '.git'
        ];

        self::copyDirectory($sourceRoot, $rootDir, $excludedPaths, $log);
        $log[] = "[" . date('Y-m-d H:i:s') . "] ✅ Archivos reemplazados respetando configuraciones y uploads existentes.";

        // Ejecutar Migraciones Pendientes
        $log[] = "[" . date('Y-m-d H:i:s') . "] 🗄️ Verificando y ejecutando migraciones de base de datos pendientes...";
        $migrationLog = self::runPendingMigrations();
        foreach ($migrationLog as $mLine) {
            $log[] = "[" . date('Y-m-d H:i:s') . "] " . $mLine;
        }

        // Actualizar archivo de versión local
        $remoteCheck = self::checkRemoteUpdate();
        $newSha = $remoteCheck['remote_commit'] ?? 'latest';
        $versionData = [
            'version' => '1.0.0',
            'commit_hash' => $newSha,
            'updated_at' => date('Y-m-d H:i:s')
        ];
        file_put_contents(__DIR__ . '/../../storage/version.json', json_encode($versionData, JSON_PRETTY_PRINT));

        // Limpiar archivos temporales
        self::deleteDirectory($tempDir);
        $log[] = "[" . date('Y-m-d H:i:s') . "] 🎉 ¡Actualización completada con éxito! Sistema sincronizado con GitHub.";

        return [
            'success' => true,
            'message' => '¡Sistema actualizado con éxito!',
            'log' => $log,
            'version' => $versionData
        ];
    }

    public static function runPendingMigrations() {
        $log = [];
        try {
            $dbConfigPath = __DIR__ . '/../../config/database.php';
            if (!file_exists($dbConfigPath)) {
                return ["⚠️ No se encontró la configuración de la base de datos."];
            }

            $dbConfig = require $dbConfigPath;
            $pdo = new PDO(
                "mysql:host={$dbConfig['host']};port={$dbConfig['port']};dbname={$dbConfig['dbname']};charset=utf8mb4",
                $dbConfig['username'],
                $dbConfig['password'],
                $dbConfig['options'] ?? []
            );

            $pdo->exec("
                CREATE TABLE IF NOT EXISTS migrations (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    migration VARCHAR(255) NOT NULL,
                    executed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
            ");

            $migrationFiles = glob(__DIR__ . '/../../database/migrations/*.php');
            sort($migrationFiles);
            $executedCount = 0;

            foreach ($migrationFiles as $file) {
                $filename = basename($file);
                $stmtCheck = $pdo->prepare("SELECT COUNT(*) FROM migrations WHERE migration = ?");
                $stmtCheck->execute([$filename]);
                if ($stmtCheck->fetchColumn() == 0) {
                    $sql = require $file;
                    if (is_callable($sql)) {
                        $sql($pdo);
                    } else if (is_string($sql) && !empty(trim($sql))) {
                        $pdo->exec($sql);
                    }
                    $stmtIns = $pdo->prepare("INSERT INTO migrations (migration) VALUES (?)");
                    $stmtIns->execute([$filename]);
                    $log[] = "Ejecutada migración: {$filename}";
                    $executedCount++;
                }
            }

            if ($executedCount === 0) {
                $log[] = "La base de datos ya se encuentra al día. No hay migraciones pendientes.";
            } else {
                $log[] = "Se ejecutaron {$executedCount} migraciones correctamente.";
            }

        } catch (\Exception $e) {
            $log[] = "❌ Error durante las migraciones: " . $e->getMessage();
        }
        return $log;
    }

    private static function copyDirectory($sourceRoot, $rootDir, $exclusions, &$log) {
        $sourceRoot = rtrim(str_replace('\\', '/', $sourceRoot), '/');
        $rootDir = rtrim(str_replace('\\', '/', $rootDir), '/');

        if (!is_dir($sourceRoot)) return;

        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($sourceRoot, \RecursiveDirectoryIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::SELF_FIRST
        );

        foreach ($iterator as $item) {
            $srcPath = str_replace('\\', '/', $item->getPathname());
            $relPath = ltrim(substr($srcPath, strlen($sourceRoot)), '/');

            if (empty($relPath)) continue;

            $isExcluded = false;
            foreach ($exclusions as $ex) {
                $ex = trim(str_replace('\\', '/', $ex), '/');
                if ($relPath === $ex || strpos($relPath, $ex . '/') === 0) {
                    $isExcluded = true;
                    break;
                }
            }

            if ($isExcluded) continue;

            $dstPath = $rootDir . '/' . $relPath;

            if ($item->isDir()) {
                if (!file_exists($dstPath)) {
                    @mkdir($dstPath, 0755, true);
                }
            } else {
                $dstDir = dirname($dstPath);
                if (!file_exists($dstDir)) {
                    @mkdir($dstDir, 0755, true);
                }
                @copy($srcPath, $dstPath);
            }
        }
    }

    private static function extractZipFile($zipPath, $extractDir, &$log) {
        self::deleteDirectory($extractDir);
        @mkdir($extractDir, 0755, true);

        // Intento 1: Extensión nativa PHP ZipArchive
        if (class_exists('\ZipArchive')) {
            try {
                $zip = new \ZipArchive();
                if ($zip->open($zipPath) === true) {
                    $zip->extractTo($extractDir);
                    $zip->close();
                    return true;
                }
            } catch (\Throwable $e) {}
        }

        // Intento 2: Extractor en Pure PHP (GZInflate / Unpack) - Funciona en el 100% de entornos PHP sin depender de php.ini ni exec
        if (function_exists('gzinflate') && self::purePhpExtractZip($zipPath, $extractDir)) {
            $log[] = "[" . date('Y-m-d H:i:s') . "] ⚡ ZIP extraído con motor Pure-PHP integrado.";
            return true;
        }

        // Intento 3: PowerShell en Windows (Expand-Archive)
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            $zipWin = str_replace('/', '\\', realpath($zipPath) ?: $zipPath);
            $parentDir = realpath(dirname($extractDir)) ?: dirname($extractDir);
            $extWin = str_replace('/', '\\', $parentDir . '/extracted');
            $cmd = 'powershell -NoProfile -ExecutionPolicy Bypass -Command "Expand-Archive -Path \'' . $zipWin . '\' -DestinationPath \'' . $extWin . '\' -Force"';
            @exec($cmd, $output, $returnVar);
            if ($returnVar === 0 && count(glob($extractDir . '/*')) > 0) {
                $log[] = "[" . date('Y-m-d H:i:s') . "] ⚡ ZIP extraído utilizando PowerShell nativo de Windows.";
                return true;
            }
        }

        // Intento 4: Utilidad unzip de sistema (Linux/macOS)
        $cmd = 'unzip -o ' . escapeshellarg($zipPath) . ' -d ' . escapeshellarg($extractDir);
        @exec($cmd, $output, $returnVar);
        if ($returnVar === 0 && count(glob($extractDir . '/*')) > 0) {
            $log[] = "[" . date('Y-m-d H:i:s') . "] ⚡ ZIP extraído utilizando la utilidad unzip del sistema.";
            return true;
        }

        return false;
    }

    private static function purePhpExtractZip($zipPath, $extractDir) {
        $fp = @fopen($zipPath, 'rb');
        if (!$fp) return false;

        @mkdir($extractDir, 0755, true);
        $extractedCount = 0;

        while (!feof($fp)) {
            $binaryHeader = fread($fp, 30);
            if (strlen($binaryHeader) < 30) break;

            $header = @unpack('Vsig/vver/vflag/vmethod/vtime/vdate/Vcrc/VcompSize/VuncompSize/vnameLen/vextraLen', $binaryHeader);

            if (!$header || $header['sig'] !== 0x04034b50) {
                break;
            }

            $filename = fread($fp, $header['nameLen']);
            $extra = $header['extraLen'] > 0 ? fread($fp, $header['extraLen']) : '';
            $compressedData = $header['compSize'] > 0 ? fread($fp, $header['compSize']) : '';

            if (empty($filename)) continue;

            if (substr($filename, -1) === '/') {
                @mkdir($extractDir . '/' . $filename, 0755, true);
                continue;
            }

            $targetPath = $extractDir . '/' . $filename;
            $targetDir = dirname($targetPath);
            if (!file_exists($targetDir)) {
                @mkdir($targetDir, 0755, true);
            }

            $uncompressedData = false;
            if ($header['method'] == 0) {
                $uncompressedData = $compressedData;
            } else if ($header['method'] == 8 && function_exists('gzinflate')) {
                $uncompressedData = @gzinflate($compressedData);
                if ($uncompressedData === false) {
                    $uncompressedData = @gzuncompress($compressedData);
                }
            }

            if ($uncompressedData !== false) {
                file_put_contents($targetPath, $uncompressedData);
                $extractedCount++;
            }
        }

        fclose($fp);
        return ($extractedCount > 0);
    }

    private static function deleteDirectory($dir) {
        if (!file_exists($dir)) return true;
        if (!is_dir($dir)) return unlink($dir);
        foreach (scandir($dir) as $item) {
            if ($item == '.' || $item == '..') continue;
            if (!self::deleteDirectory($dir . DIRECTORY_SEPARATOR . $item)) return false;
        }
        return rmdir($dir);
    }
}
