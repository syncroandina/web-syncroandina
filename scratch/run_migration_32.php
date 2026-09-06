<?php
require __DIR__ . '/../vendor/autoload.php';
$config = require __DIR__ . '/../config/database.php';

try {
    $db = new PDO(
        "mysql:host={$config['host']};dbname={$config['dbname']};charset={$config['charset']}",
        $config['username'],
        $config['password'],
        $config['options']
    );
    
    // Check if column content exists in services_pages
    $stmt = $db->query("SHOW COLUMNS FROM services_pages LIKE 'content'");
    $column = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($column) {
        echo "Copiando datos de content a consists_of y eliminando columna content...\n";
        $db->exec("UPDATE services_pages SET consists_of = content WHERE (consists_of IS NULL OR consists_of = '') AND content IS NOT NULL AND content != ''");
        $db->exec("ALTER TABLE services_pages DROP COLUMN content");
        echo "✅ Columna 'content' eliminada con éxito de 'services_pages'.\n";
    } else {
        echo "ℹ️ La columna 'content' ya no existe en 'services_pages'.\n";
    }

    // Registrar en tabla migrations si existe
    $db->exec("CREATE TABLE IF NOT EXISTS migrations (id INT AUTO_INCREMENT PRIMARY KEY, migration VARCHAR(255) NOT NULL, executed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP)");
    $stmt = $db->prepare("INSERT IGNORE INTO migrations (migration) VALUES (?)");
    $stmt->execute(['32_alter_services_pages_drop_content.php']);

} catch (PDOException $e) {
    echo "❌ Error DB: " . $e->getMessage() . "\n";
}
