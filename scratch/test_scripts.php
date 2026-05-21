<?php
require 'vendor/autoload.php';
$config = require 'config/database.php';
$db = new PDO(
    "mysql:host={$config['host']};dbname={$config['dbname']};charset={$config['charset']}",
    $config['username'],
    $config['password'],
    $config['options']
);

// Verificar si ya existen scripts de prueba
$stmt = $db->query("SELECT COUNT(*) FROM scripts WHERE name LIKE 'Test%'");
$count = $stmt->fetchColumn();

if ($count == 0) {
    $codeGlobal = '<!-- TEST GLOBAL HEAD --><script>console.log("[SCRIPT GLOBAL] Head inyectado correctamente - Todo el sitio");</script>';
    $codeConversion = '<!-- TEST CONVERSION --><script>console.log("[SCRIPT CONVERSION] Body_end inyectado en pagina de Gracias");</script>';

    $stmt = $db->prepare("INSERT INTO scripts (name, code, placement, page_restriction, is_active) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute(['Test Global Head', $codeGlobal, 'head', 'all', 1]);
    $stmt->execute(['Test Conversion Gracias', $codeConversion, 'body_end', 'thanks_only', 1]);
    echo "Scripts de prueba insertados correctamente.\n";
} else {
    echo "Ya existen $count scripts de prueba. No se insertaron duplicados.\n";
}

// Mostrar todos los scripts
echo "\nESTADO ACTUAL DE LA TABLA SCRIPTS:\n";
echo str_repeat('-', 90) . "\n";
$stmt = $db->query("SELECT id, name, placement, page_restriction, is_active FROM scripts ORDER BY id ASC");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach ($rows as $r) {
    echo sprintf(
        "ID: %2d | %-30s | %-12s | %-12s | Activo: %s\n",
        $r['id'],
        $r['name'],
        $r['placement'],
        $r['page_restriction'],
        $r['is_active'] ? 'SI' : 'NO'
    );
}
echo str_repeat('-', 90) . "\n";
echo "Total scripts: " . count($rows) . "\n";
