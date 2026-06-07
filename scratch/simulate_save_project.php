<?php
// Cargar archivos necesarios
require_once __DIR__ . '/../core/Model.php';
require_once __DIR__ . '/../app/models/Project.php';

$dbConfig = require __DIR__ . '/../config/database.php';
try {
    $pdo = new PDO("mysql:host={$dbConfig['host']};dbname={$dbConfig['dbname']};charset={$dbConfig['charset']}", $dbConfig['username'], $dbConfig['password'], $dbConfig['options']);
    // Iniciar transacción para no ensuciar la base de datos
    $pdo->beginTransaction();
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage() . "\n");
}

echo "Simulando guardado de un nuevo proyecto...\n";

// Definimos un mock del modelo Project para usar la conexión de prueba
class TestProject extends \App\Models\Project {
    public function __construct($pdo) {
        $this->db = $pdo;
    }
}

$projectModel = new TestProject($pdo);

// Datos simulados (parecidos a los que enviaría el formulario)
$data = [
    'title' => 'Proyecto de Prueba Automatizado',
    'slug' => 'proyecto-de-prueba-automatizado-' . time(),
    'description' => 'Descripción detallada de nuestro proyecto de prueba.',
    'client' => 'Cliente de Prueba',
    'completion_date' => '2026-06-06',
    'is_active' => 1,
    'challenge_title' => 'El Reto de Prueba',
    'challenge_desc' => 'Descripción del reto de prueba.',
    'solution_title' => 'La Solución de Prueba',
    'solution_desc' => 'Descripción de la solución de prueba.',
    'impact_label' => 'Impacto Logrado',
    'impact_value' => '100% Exitoso',
    'image_alt' => 'Texto alternativo de prueba',
    'seo_title' => 'Título SEO de Prueba',
    'seo_description' => 'Descripción SEO de Prueba',
    'seo_keywords' => 'palabras, clave, prueba'
];

try {
    $result = $projectModel->save($data);
    echo "[OK] Proyecto guardado exitosamente. Resultado de save(): " . var_export($result, true) . "\n";
    
    // Si save() es exitoso, obtener el ID insertado
    $lastId = $pdo->lastInsertId();
    echo "ID del nuevo proyecto insertado: $lastId\n";
    
    if (empty($lastId) || $lastId == 0) {
        echo "[FAIL] lastInsertId es vacío o 0, lo cual indica que la inserción falló o no retornó el ID correcto.\n";
    }
    
    // Intentar consultar el proyecto insertado
    $stmt = $pdo->prepare("SELECT * FROM projects WHERE id = ?");
    $stmt->execute([$lastId]);
    $insertedProject = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($insertedProject) {
        echo "[OK] Proyecto verificado en la base de datos.\n";
    } else {
        echo "[FAIL] No se encontró el proyecto con ID $lastId en la base de datos.\n";
    }
} catch (Exception $e) {
    echo "[EXCEPTION] Error al guardar proyecto: " . $e->getMessage() . "\n";
    echo "Trace: \n" . $e->getTraceAsString() . "\n";
}

// Deshacer la transacción para dejar la base de datos intacta
$pdo->rollBack();
echo "Simulación terminada. Transacción deshecha.\n";
