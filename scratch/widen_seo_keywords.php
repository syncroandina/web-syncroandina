<?php
$config = require __DIR__ . '/../config/database.php';
try {
    $pdo = new PDO("mysql:host={$config['host']};dbname={$config['dbname']};charset={$config['charset']}", $config['username'], $config['password'], $config['options']);
    
    // Ampliar la longitud de la columna seo_keywords en services_pages
    $pdo->exec("ALTER TABLE services_pages MODIFY COLUMN seo_keywords VARCHAR(1000) NULL");
    echo "[OK] Columna seo_keywords ampliada en la tabla services_pages.\n";
    
    // Ampliar la longitud de la columna seo_keywords en projects
    $pdo->exec("ALTER TABLE projects MODIFY COLUMN seo_keywords VARCHAR(1000) NULL");
    echo "[OK] Columna seo_keywords ampliada en la tabla projects.\n";
    
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
