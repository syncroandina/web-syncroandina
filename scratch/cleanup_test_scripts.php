<?php
require 'vendor/autoload.php';
$config = require 'config/database.php';
$db = new PDO(
    "mysql:host={$config['host']};dbname={$config['dbname']};charset={$config['charset']}",
    $config['username'],
    $config['password'],
    $config['options']
);
$deleted = $db->exec("DELETE FROM scripts WHERE name LIKE 'Test%'");
echo "Scripts de prueba eliminados: $deleted fila(s).\n";
