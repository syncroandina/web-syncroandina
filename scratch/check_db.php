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
    
    // Ver las tablas
    $stmt = $db->query("SHOW TABLES");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    echo "Tablas existentes:\n";
    print_r($tables);
    
    if (in_array('scripts', $tables)) {
        echo "\nLa tabla 'scripts' existe. Estructura:\n";
        $stmt = $db->query("DESCRIBE scripts");
        print_r($stmt->fetchAll(PDO::FETCH_ASSOC));
    } else {
        echo "\nLa tabla 'scripts' NO existe.\n";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
