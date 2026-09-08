<?php
/**
 * Script de Generación de Backup de Base de Datos (SQL Dump)
 * Genera un respaldo completo de la estructura y datos de MySQL en backup_bd/
 */

if (php_sapi_name() !== 'cli') {
    echo "<pre>";
}

echo "=========================================================\n";
echo " 💾 Generando Backup de Base de Datos MySQL\n";
echo "=========================================================\n\n";

$configPath = __DIR__ . '/config/database.php';

if (!file_exists($configPath)) {
    die("❌ Error: No existe la configuración config/database.php. El sitio aún no ha sido instalado.\n");
}

$config = require $configPath;
$backupDir = __DIR__ . '/backup_bd';

if (!is_dir($backupDir)) {
    @mkdir($backupDir, 0755, true);
}

$portStr = !empty($config['port']) ? ";port={$config['port']}" : "";

try {
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

    if (empty($tables)) {
        die("⚠️ La base de datos está vacía. No hay tablas para respaldar.\n");
    }

    $sqlDump = "-- =========================================================\n";
    $sqlDump .= "-- Backup de Base de Datos MySQL - Syncro Andina Web\n";
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

        // Exportar datos
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

    $timestamp = date('Y-m-d_H-i-s');
    $backupFilename = "backup_{$config['dbname']}_{$timestamp}.sql";
    $latestFilename = "latest_backup.sql";
    $backupBdFilename = "backup_bd.sql";

    $backupDir = __DIR__ . '/backup_bd';

    if (!is_dir($backupDir)) {
        @mkdir($backupDir, 0755, true);
    }

    $backupPath = $backupDir . '/' . $backupFilename;
    $latestPath = $backupDir . '/' . $latestFilename;
    $backupBdSqlPath = $backupDir . '/backup_bd.sql';

    file_put_contents($backupPath, $sqlDump);
    file_put_contents($latestPath, $sqlDump);
    file_put_contents($backupBdSqlPath, $sqlDump);

    // Eliminar archivo legacy backup-db.sql si existe dentro de backup_bd/
    if (file_exists($backupDir . '/backup-db.sql')) {
        @unlink($backupDir . '/backup-db.sql');
    }

    $sizeKb = round(filesize($backupBdSqlPath) / 1024, 2);

    echo "=========================================================\n";
    echo " ✅ ¡Backup de Base de Datos generado exitosamente!\n";
    echo " 📂 Carpeta: backup_bd/\n";
    echo " 📄 Archivo SQL: backup_bd/backup_bd.sql\n";
    echo " 📄 Archivo acumulado: backup_bd/latest_backup.sql\n";
    echo " 📊 Tamaño: {$sizeKb} KB\n";
    echo " 📋 Tablas respaldadas: " . count($tables) . "\n";
    echo "=========================================================\n";

} catch (PDOException $e) {
    echo "❌ Error al generar el backup: " . $e->getMessage() . "\n";
}

if (php_sapi_name() !== 'cli') {
    echo "</pre>";
}
