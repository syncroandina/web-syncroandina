<?php
require_once __DIR__ . '/../vendor/autoload.php';

$dbConfig = require __DIR__ . '/../config/database.php';
$dsn = "mysql:host={$dbConfig['host']};dbname={$dbConfig['db_name']};charset={$dbConfig['charset']}";
$pdo = new PDO($dsn, $dbConfig['username'], $dbConfig['password'], [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
]);

$stmt = $pdo->query("SELECT id, title, slug, is_active FROM projects ORDER BY id ASC");
$projects = $stmt->fetchAll();

echo "--- ALL PROJECTS IN DB ---\n";
foreach ($projects as $p) {
    echo "ID: {$p['id']} | Active: {$p['is_active']} | Title: {$p['title']}\n";
}
