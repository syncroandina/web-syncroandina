<?php
require __DIR__ . '/../vendor/autoload.php';
$config = require __DIR__ . '/../config/database.php';

try {
    $dsn = "mysql:host={$config['host']};dbname={$config['dbname']};charset={$config['charset']}";
    $db = new PDO($dsn, $config['username'], $config['password'], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);

    // Agregar la columna top_label si no existe
    $db->exec("ALTER TABLE sliders ADD COLUMN top_label VARCHAR(255) DEFAULT 'SYNCRO ANDINA INGENIERÍA' AFTER title");
    
    echo "Columna 'top_label' añadida con éxito.\n";

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
