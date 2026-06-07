<?php
$config = require __DIR__ . '/../config/database.php';
try {
    $pdo = new PDO("mysql:host={$config['host']};dbname={$config['dbname']};charset={$config['charset']}", $config['username'], $config['password'], $config['options']);
    
    // Añadir columnas de SEO si no existen
    $sql = "ALTER TABLE services_pages 
            ADD COLUMN seo_title VARCHAR(255) NULL AFTER cta_description,
            ADD COLUMN seo_description VARCHAR(1000) NULL AFTER seo_title,
            ADD COLUMN seo_keywords VARCHAR(255) NULL AFTER seo_description";
            
    $pdo->exec($sql);
    echo "[OK] Columnas de SEO añadidas con éxito a services_pages.\n";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
