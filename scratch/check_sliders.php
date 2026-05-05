<?php
require __DIR__ . '/../vendor/autoload.php';
$config = require __DIR__ . '/../config/database.php';

try {
    $dsn = "mysql:host={$config['host']};dbname={$config['dbname']};charset={$config['charset']}";
    $db = new PDO($dsn, $config['username'], $config['password'], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);

    $stmt = $db->query("SELECT * FROM sliders");
    $sliders = $stmt->fetchAll();
    echo "Total sliders: " . count($sliders) . "\n";
    foreach($sliders as $s) {
        echo "ID: {$s['id']}, Title: {$s['title']}, Active: {$s['is_active']}\n";
    }

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
