<?php
require __DIR__ . '/vendor/autoload.php';
$config = require __DIR__ . '/config/database.php';

try {
    $db = new PDO(
        "mysql:host={$config['host']};dbname={$config['dbname']};charset={$config['charset']}",
        $config['username'],
        $config['password'],
        $config['options']
    );
    
    // Crear tabla para llevar registro de migraciones
    $db->exec("
        CREATE TABLE IF NOT EXISTS migrations (
            id INT AUTO_INCREMENT PRIMARY KEY,
            migration VARCHAR(255) NOT NULL,
            executed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )
    ");
    
    $stmt = $db->query("SELECT migration FROM migrations");
    $executed = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    $files = glob(__DIR__ . '/database/migrations/*.php');
    sort($files);
    
    foreach ($files as $file) {
        $filename = basename($file);
        if (!in_array($filename, $executed)) {
            echo "Ejecutando migración: {$filename}\n";
            $sql = require $file;
            $db->exec($sql);
            
            $stmt = $db->prepare("INSERT INTO migrations (migration) VALUES (?)");
            $stmt->execute([$filename]);
            echo "✅ Migrada con éxito: {$filename}\n";
        }
    }
    
    echo "\n🎉 ¡Todas las migraciones se ejecutaron correctamente!\n";
    
} catch (PDOException $e) {
    die("❌ Error en la base de datos: " . $e->getMessage() . "\n");
}
