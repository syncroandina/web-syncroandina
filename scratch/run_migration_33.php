<?php
require_once __DIR__ . '/../vendor/autoload.php';

$dbConfig = require __DIR__ . '/../config/database.php';
$dsn = "mysql:host={$dbConfig['host']};dbname={$dbConfig['db_name']};charset={$dbConfig['charset']}";
$pdo = new PDO($dsn, $dbConfig['username'], $dbConfig['password'], [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);

try {
    $pdo->exec("ALTER TABLE services_pages ADD COLUMN heading_projects VARCHAR(255) DEFAULT 'Proyectos relacionados'");
    echo "Added heading_projects column.\n";
} catch (\PDOException $e) {
    echo "heading_projects column already exists or error: " . $e->getMessage() . "\n";
}

try {
    $pdo->exec("ALTER TABLE services_pages ADD COLUMN related_projects_json TEXT NULL");
    echo "Added related_projects_json column.\n";
} catch (\PDOException $e) {
    echo "related_projects_json column already exists or error: " . $e->getMessage() . "\n";
}
