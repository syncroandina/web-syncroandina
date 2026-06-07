<?php
$config = require __DIR__ . '/../config/database.php';
try {
    $pdo = new PDO("mysql:host={$config['host']};dbname={$config['dbname']};charset={$config['charset']}", $config['username'], $config['password'], $config['options']);
    $stmt = $pdo->query("SELECT id, title, slug, content FROM services_pages");
    $services = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($services as $service) {
        echo "========================================\n";
        echo "ID: " . $service['id'] . "\n";
        echo "TITLE: " . $service['title'] . "\n";
        echo "SLUG: " . $service['slug'] . "\n";
        
        // Obtener galería
        $gStmt = $pdo->prepare("SELECT id, image_path, image_alt, sort_order FROM service_gallery WHERE service_id = ?");
        $gStmt->execute([$service['id']]);
        $gallery = $gStmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo "GALLERY ENTRIES:\n";
        print_r($gallery);
        
        echo "CONTENT RAW:\n" . $service['content'] . "\n";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
