<?php

$config = require __DIR__ . '/../config/database.php';
$pdo = new PDO("mysql:host={$config['host']};dbname={$config['dbname']};charset={$config['charset']}", $config['username'], $config['password'], $config['options']);

// Reorder menu links to make room
$pdo->exec("UPDATE menu_links SET order_index = order_index + 1 WHERE order_index >= 4");

// Insert Repuestos
$stmt = $pdo->prepare("SELECT id FROM menu_links WHERE url = '/repuestos'");
$stmt->execute();
if (!$stmt->fetch()) {
    $stmt = $pdo->prepare("INSERT INTO menu_links (title, url, order_index, is_active) VALUES ('Repuestos', '/repuestos', 4, 1)");
    $stmt->execute();
    echo "Added Repuestos to menu_links\n";
} else {
    echo "Repuestos already in menu_links\n";
}
