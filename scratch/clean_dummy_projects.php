<?php
require_once __DIR__ . '/../vendor/autoload.php';

$dbConfig = require __DIR__ . '/../config/database.php';
$dsn = "mysql:host={$dbConfig['host']};dbname={$dbConfig['db_name']};charset={$dbConfig['charset']}";
$pdo = new PDO($dsn, $dbConfig['username'], $dbConfig['password'], [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
]);

// Eliminar proyectos huérfanos / prueba
$sql = "DELETE FROM projects WHERE title LIKE '%Migración Cloud%' OR title LIKE '%App Móvil%' OR title LIKE '%Copia%' OR title LIKE '%Test%'";
$deletedCount = $pdo->exec($sql);

echo "Deleted $deletedCount dummy/orphan projects from database.\n";

$stmt = $pdo->query("SELECT id, title, slug, is_active FROM projects ORDER BY id ASC");
$remaining = $stmt->fetchAll();

echo "--- REMAINING REAL PROJECTS ---\n";
foreach ($remaining as $p) {
    echo "ID: {$p['id']} | Title: {$p['title']}\n";
}
