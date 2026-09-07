<?php
/**
 * Script Empaquetador de Instalador Web para Syncro Andina CMS
 * Genera el archivo syncroandina_installer.zip de forma ultrarrápida.
 */

if (php_sapi_name() !== 'cli') {
    echo "<pre>";
}

echo "=========================================================\n";
echo " 📦 Empaquetador de Instalador ZIP (Ultra-Fast Build)\n";
echo "=========================================================\n\n";

$rootDir = __DIR__;
$distDir = $rootDir . '/dist';
if (!is_dir($distDir)) {
    @mkdir($distDir, 0755, true);
}
$outputZip = $distDir . '/syncroandina_installer.zip';

// Eliminar zip previo si existe
if (file_exists($outputZip)) {
    @unlink($outputZip);
}

// Archivos y patrones a ignorar
$ignorePatterns = [
    '^\.git',
    '^\.agents',
    '^scratch',
    '^node_modules',
    '^\.env',
    '^dist',
    '^config/database\.php$',
    '^storage/installed\.lock$',
    '^storage/tmp_build_zip',
    '^storage/.*\.log$',
    '^syncroandina_installer\.zip$',
    '^build_installer\.php$',
    '^build\.js$',
    '^backup_bd',
    '^backup\.php$'
];

$filesAdded = 0;
$startTime = microtime(true);

echo "📋 Procesando y comprimiendo archivos directamente...\n";

if (class_exists('ZipArchive')) {
    $zip = new ZipArchive();
    if ($zip->open($outputZip, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($rootDir, RecursiveDirectoryIterator::SKIP_DOTS),
            RecursiveIteratorIterator::SELF_FIRST
        );

        foreach ($iterator as $file) {
            $filePath = $file->getRealPath();
            $relativePath = str_replace('\\', '/', substr($filePath, strlen($rootDir) + 1));

            $shouldIgnore = false;
            foreach ($ignorePatterns as $pattern) {
                if (preg_match("#{$pattern}#i", $relativePath)) {
                    $shouldIgnore = true;
                    break;
                }
            }

            if ($shouldIgnore) continue;

            if ($file->isDir()) {
                $zip->addEmptyDir($relativePath);
            } else if ($file->isFile()) {
                // Excluir uploads dinámicos excepto .gitkeep
                if (strpos($relativePath, 'public/uploads/') === 0 && basename($relativePath) !== '.gitkeep') {
                    continue;
                }

                $zip->addFile($filePath, $relativePath);
                $filesAdded++;
            }
        }

        // Asegurar carpetas vacías clave
        $zip->addEmptyDir('config');
        $zip->addEmptyDir('storage');
        $zip->addEmptyDir('public/uploads/services');

        $zip->close();
    }
} else {
    // Fallback con carpeta temporal solo si ZipArchive no está activo en PHP
    $tempDir = $rootDir . '/storage/tmp_build_zip';
    if (is_dir($tempDir)) {
        @exec("rmdir /s /q \"{$tempDir}\"");
    }
    @mkdir($tempDir, 0755, true);

    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($rootDir, RecursiveDirectoryIterator::SKIP_DOTS),
        RecursiveIteratorIterator::SELF_FIRST
    );

    foreach ($iterator as $file) {
        $filePath = $file->getRealPath();
        $relativePath = str_replace('\\', '/', substr($filePath, strlen($rootDir) + 1));

        $shouldIgnore = false;
        foreach ($ignorePatterns as $pattern) {
            if (preg_match("#{$pattern}#i", $relativePath)) {
                $shouldIgnore = true;
                break;
            }
        }
        if ($shouldIgnore) continue;

        $targetPath = $tempDir . '/' . $relativePath;
        if ($file->isDir()) {
            @mkdir($targetPath, 0755, true);
        } else if ($file->isFile()) {
            if (strpos($relativePath, 'public/uploads/') === 0 && basename($relativePath) !== '.gitkeep') {
                continue;
            }
            $targetDir = dirname($targetPath);
            if (!is_dir($targetDir)) @mkdir($targetDir, 0755, true);
            copy($filePath, $targetPath);
            $filesAdded++;
        }
    }

    if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
        $cmd = "tar -a -cf \"{$outputZip}\" -C \"{$tempDir}\" .";
        @exec($cmd, $out, $ret);
        if (!file_exists($outputZip) || filesize($outputZip) === 0) {
            $psCommand = "Compress-Archive -Path '{$tempDir}\\*' -DestinationPath '{$outputZip}' -Force";
            @exec("powershell -NoProfile -NonInteractive -Command \"{$psCommand}\"");
        }
    } else {
        exec("cd \"{$tempDir}\" && zip -r \"{$outputZip}\" .");
    }

    if (is_dir($tempDir)) {
        @exec("rmdir /s /q \"{$tempDir}\"");
    }
}

$executionTime = round(microtime(true) - $startTime, 2);

// Corroboración física real en el sistema de archivos del SO
$zipVerified = false;
$attempts = 0;
$maxAttempts = 30;
$lastSize = -1;

while ($attempts < $maxAttempts) {
    clearstatcache(true, $outputZip);
    if (file_exists($outputZip)) {
        $currentSize = filesize($outputZip);
        if ($currentSize > 0 && $currentSize === $lastSize) {
            $zipVerified = true;
            break;
        }
        $lastSize = $currentSize;
    }
    usleep(100000); // Esperar 100ms a que el SO complete la escritura
    $attempts++;
}

if ($zipVerified) {
    $zipSize = round(filesize($outputZip) / 1024 / 1024, 2);
    echo "\n=========================================================\n";
    echo " ✅ ¡Archivo ZIP verificado en disco y listo en {$executionTime} segundos!\n";
    echo " 📄 Ruta física: dist/syncroandina_installer.zip\n";
    echo " 📊 Tamaño: {$zipSize} MB\n";
    echo " 📁 Archivos empaquetados: {$filesAdded}\n";
    echo "=========================================================\n";
    echo " 🚀 Listo para subir y descomprimir en producción.\n";
    echo "=========================================================\n";
} else {
    echo "\n❌ Error: No se pudo verificar la presencia del archivo ZIP en el disco. Revisa los permisos.\n";
}

if (php_sapi_name() !== 'cli') {
    echo "</pre>";
}
