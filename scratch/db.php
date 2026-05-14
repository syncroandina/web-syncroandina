<?php
$c = require __DIR__ . '/../config/database.php';
$pdo = new PDO('mysql:host='.$c['host'].';dbname='.$c['dbname'], $c['username'], $c['password']);
$stmt = $pdo->query('SELECT id, title, main_image FROM products');
print_r($stmt->fetchAll(PDO::FETCH_ASSOC));
