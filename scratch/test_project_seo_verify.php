<?php
$dbConfig = require __DIR__ . '/../config/database.php';
try {
    $pdo = new PDO("mysql:host={$dbConfig['host']};dbname={$dbConfig['dbname']};charset={$dbConfig['charset']}", $dbConfig['username'], $dbConfig['password'], $dbConfig['options']);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage() . "\n");
}

echo "Verificando estructura de la base de datos para proyectos...\n";
$stmt = $pdo->query("DESCRIBE projects");
$columns = $stmt->fetchAll(PDO::FETCH_COLUMN);

$expectedCols = ['seo_title', 'seo_description', 'seo_keywords'];
$missing = [];
foreach ($expectedCols as $col) {
    if (!in_array($col, $columns)) {
        $missing[] = $col;
    }
}

if (!empty($missing)) {
    die("[FAIL] Faltan columnas en la tabla projects: " . implode(', ', $missing) . "\n");
}
echo "[OK] Las columnas seo_title, seo_description y seo_keywords existen en la tabla projects.\n";

// Obtener el primer proyecto activo
$stmt = $pdo->query("SELECT * FROM projects LIMIT 1");
$project = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$project) {
    die("[WARN] No hay proyectos registrados para probar la persistencia. Por favor crea uno en la administración.\n");
}

$id = $project['id'];
echo "Probando actualización de SEO para el proyecto ID: $id ('{$project['title']}')\n";

// Guardar valores antiguos para restaurarlos después
$oldSeoTitle = $project['seo_title'];
$oldSeoDesc = $project['seo_description'];
$oldSeoKey = $project['seo_keywords'];

$testTitle = "Título SEO de Proyecto " . time();
$testDesc = "Descripción SEO de Proyecto para validar el correcto almacenamiento en la base de datos " . time();
$testKey = "proyecto, prueba, seo, automatizado, " . time();

// Actualizar con PDO
$updateStmt = $pdo->prepare("UPDATE projects SET seo_title = ?, seo_description = ?, seo_keywords = ? WHERE id = ?");
$updateStmt->execute([$testTitle, $testDesc, $testKey, $id]);

// Consultar de nuevo
$stmt = $pdo->prepare("SELECT seo_title, seo_description, seo_keywords FROM projects WHERE id = ?");
$stmt->execute([$id]);
$updated = $stmt->fetch(PDO::FETCH_ASSOC);

if ($updated['seo_title'] === $testTitle && $updated['seo_description'] === $testDesc && $updated['seo_keywords'] === $testKey) {
    echo "[OK] Persistencia en BD exitosa. Los valores SEO del proyecto se guardan y leen correctamente.\n";
} else {
    echo "[FAIL] La persistencia falló. Valores no coinciden.\n";
}

// Restaurar valores anteriores
$updateStmt->execute([$oldSeoTitle, $oldSeoDesc, $oldSeoKey, $id]);
echo "[OK] Valores originales restaurados para el proyecto ID: $id.\n";
