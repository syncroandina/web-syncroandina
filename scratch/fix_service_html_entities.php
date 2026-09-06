<?php
require_once __DIR__ . '/../vendor/autoload.php';

// Cargar configuración de base de datos
$dbConfig = require __DIR__ . '/../config/database.php';
$dsn = "mysql:host={$dbConfig['host']};dbname={$dbConfig['db_name']};charset={$dbConfig['charset']}";
$pdo = new PDO($dsn, $dbConfig['username'], $dbConfig['password'], [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
]);

function cleanEntities($val) {
    if (empty($val)) return '';
    while (preg_match('/&(lt|gt|amp|quot|#039);/i', $val)) {
        $decoded = html_entity_decode($val, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        if ($decoded === $val) break;
        $val = $decoded;
    }
    return $val;
}

$stmt = $pdo->query("SELECT id, cta_description, consists_of, materials_methodology, pricing_timeline, why_choose_us, coverage FROM services");
$services = $stmt->fetchAll();

$fields = ['cta_description', 'consists_of', 'materials_methodology', 'pricing_timeline', 'why_choose_us', 'coverage'];

$updateStmt = $pdo->prepare("UPDATE services SET cta_description = ?, consists_of = ?, materials_methodology = ?, pricing_timeline = ?, why_choose_us = ?, coverage = ? WHERE id = ?");

$count = 0;
foreach ($services as $service) {
    $updated = [];
    foreach ($fields as $field) {
        $updated[$field] = cleanEntities($service[$field] ?? '');
    }
    $updateStmt->execute([
        $updated['cta_description'],
        $updated['consists_of'],
        $updated['materials_methodology'],
        $updated['pricing_timeline'],
        $updated['why_choose_us'],
        $updated['coverage'],
        $service['id']
    ]);
    $count++;
}

echo "Cleaned HTML entities for $count services successfully.\n";
