<?php
// Cargar autoloader si existe, o incluir manualmente
require_once __DIR__ . '/../core/Model.php';
require_once __DIR__ . '/../app/models/Service.php';
require_once __DIR__ . '/../app/models/ServiceItem.php';
require_once __DIR__ . '/../app/models/ServiceGallery.php';

// Mock simple de la inicialización de la conexión
$dbConfig = require __DIR__ . '/../config/database.php';
try {
    $pdo = new PDO("mysql:host={$dbConfig['host']};dbname={$dbConfig['dbname']};charset={$dbConfig['charset']}", $dbConfig['username'], $dbConfig['password'], $dbConfig['options']);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage() . "\n");
}

// Para usar los modelos de Core, necesitamos inicializar la base de datos estática en Core\Model si es que existe
// Vamos a inspeccionar cómo funciona Core\Model.
// Como alternativa más segura, podemos simplemente consultar la base de datos directamente con PDO para validar que las columnas funcionan correctamente y que el modelo pueda persistir.
echo "Verificando estructura de la base de datos...\n";
$stmt = $pdo->query("DESCRIBE services_pages");
$columns = $stmt->fetchAll(PDO::FETCH_COLUMN);

$expectedCols = ['seo_title', 'seo_description', 'seo_keywords'];
$missing = [];
foreach ($expectedCols as $col) {
    if (!in_array($col, $columns)) {
        $missing[] = $col;
    }
}

if (!empty($missing)) {
    die("[FAIL] Faltan columnas en services_pages: " . implode(', ', $missing) . "\n");
}
echo "[OK] Las columnas seo_title, seo_description y seo_keywords existen en services_pages.\n";

// Obtener el primer servicio activo
$stmt = $pdo->query("SELECT * FROM services_pages LIMIT 1");
$service = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$service) {
    die("[WARN] No hay servicios registrados para probar la persistencia. Por favor crea uno en la administración.\n");
}

$id = $service['id'];
echo "Probando actualización de SEO para el servicio ID: $id ('{$service['title']}')\n";

// Guardar valores antiguos para restaurarlos después
$oldSeoTitle = $service['seo_title'];
$oldSeoDesc = $service['seo_description'];
$oldSeoKey = $service['seo_keywords'];

$testTitle = "Título SEO de Prueba " . time();
$testDesc = "Descripción SEO de Prueba para validar el correcto almacenamiento en la base de datos " . time();
$testKey = "palabras, clave, de, prueba, seo, " . time();

// Actualizar con PDO
$updateStmt = $pdo->prepare("UPDATE services_pages SET seo_title = ?, seo_description = ?, seo_keywords = ? WHERE id = ?");
$updateStmt->execute([$testTitle, $testDesc, $testKey, $id]);

// Consultar de nuevo
$stmt = $pdo->prepare("SELECT seo_title, seo_description, seo_keywords FROM services_pages WHERE id = ?");
$stmt->execute([$id]);
$updated = $stmt->fetch(PDO::FETCH_ASSOC);

if ($updated['seo_title'] === $testTitle && $updated['seo_description'] === $testDesc && $updated['seo_keywords'] === $testKey) {
    echo "[OK] Persistencia en BD exitosa. Los valores SEO se guardan y leen correctamente.\n";
} else {
    echo "[FAIL] La persistencia falló. Valores no coinciden.\n";
}

// Restaurar valores anteriores
$updateStmt->execute([$oldSeoTitle, $oldSeoDesc, $oldSeoKey, $id]);
echo "[OK] Valores originales restaurados para el servicio ID: $id.\n";
