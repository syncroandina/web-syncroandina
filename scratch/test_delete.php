<?php
/**
 * Script de prueba de integración para validar la eliminación de archivos de la galería.
 */

require __DIR__ . '/../vendor/autoload.php';

echo "Iniciando prueba de borrado automático de archivos...\n";

$serviceModel = new \App\Models\Service();
$galleryModel = new \App\Models\ServiceGallery();
$itemModel = new \App\Models\ServiceItem();

// Rutas de archivos de prueba
$baseDir = __DIR__ . '/../public';
$mainImgPath = '/assets/images/services/dummy_main.jpg';
$g1ImgPath = '/assets/images/services/gallery/dummy_g1.jpg';
$g2ImgPath = '/assets/images/services/gallery/dummy_g2.jpg';

// Crear archivos físicos ficticios
file_put_contents($baseDir . $mainImgPath, 'dummy data main');
file_put_contents($baseDir . $g1ImgPath, 'dummy data g1');
file_put_contents($baseDir . $g2ImgPath, 'dummy data g2');

// Validar creación de archivos
if (file_exists($baseDir . $mainImgPath) && file_exists($baseDir . $g1ImgPath) && file_exists($baseDir . $g2ImgPath)) {
    echo "[OK] Archivos de prueba creados físicamente en el disco.\n";
} else {
    echo "[FAIL] Error al crear archivos físicos en disco.\n";
    exit(1);
}

// Insertar registros en BD
try {
    $serviceId = $serviceModel->save([
        'title' => 'Servicio Test Borrado',
        'slug' => 'servicio-test-borrado',
        'heading_description' => 'Servicio de prueba para validar que borre imágenes de la galería',
        'image' => $mainImgPath,
        'is_active' => 0
    ]);

    $g1Id = $galleryModel->save([
        'service_id' => $serviceId,
        'image_path' => $g1ImgPath,
        'sort_order' => 1
    ]);

    $g2Id = $galleryModel->save([
        'service_id' => $serviceId,
        'image_path' => $g2ImgPath,
        'sort_order' => 2
    ]);

    $itemId = $itemModel->save([
        'service_id' => $serviceId,
        'title' => 'Item Test Borrado',
        'description' => 'Item descriptivo de prueba',
        'sort_order' => 1
    ]);

    echo "[OK] Registros dummy guardados en la BD (Service ID: $serviceId).\n";
} catch (\Exception $e) {
    echo "[FAIL] Error al escribir en base de datos: " . $e->getMessage() . "\n";
    // Limpiar archivos físicos por si acaso
    @unlink($baseDir . $mainImgPath);
    @unlink($baseDir . $g1ImgPath);
    @unlink($baseDir . $g2ImgPath);
    exit(1);
}

// Ejecutar lógica de borrado de deleteService
echo "Simulando eliminación del servicio...\n";

$service = $serviceModel->find($serviceId);
if ($service) {
    // 1. Eliminar imagen principal físicamente
    if (!empty($service['image'])) {
        \Core\FileHelper::delete($service['image']);
    }

    // 2. Eliminar imágenes de la galería físicamente
    $galleryImages = $galleryModel->getByService($serviceId);
    if (!empty($galleryImages)) {
        foreach ($galleryImages as $image) {
            if (!empty($image['image_path'])) {
                \Core\FileHelper::delete($image['image_path']);
            }
        }
    }

    // 3. Eliminar relaciones en base de datos de manera explícita
    $galleryModel->deleteByService($serviceId);
    $itemModel->deleteByService($serviceId);

    // 4. Eliminar el servicio principal
    $serviceModel->delete($serviceId);
    echo "[OK] Lógica de borrado completada.\n";
} else {
    echo "[FAIL] No se pudo encontrar el servicio recién guardado.\n";
}

// VALIDAR RESULTADOS
$errors = 0;

// Validar que los archivos ya no estén en disco
if (file_exists($baseDir . $mainImgPath)) {
    echo "[FAIL] El archivo de imagen principal sigue existiendo en el disco.\n";
    $errors++;
    @unlink($baseDir . $mainImgPath);
} else {
    echo "[OK] El archivo de imagen principal fue eliminado físicamente.\n";
}

if (file_exists($baseDir . $g1ImgPath)) {
    echo "[FAIL] El archivo de galería G1 sigue existiendo en el disco.\n";
    $errors++;
    @unlink($baseDir . $g1ImgPath);
} else {
    echo "[OK] El archivo de galería G1 fue eliminado físicamente.\n";
}

if (file_exists($baseDir . $g2ImgPath)) {
    echo "[FAIL] El archivo de galería G2 sigue existiendo en el disco.\n";
    $errors++;
    @unlink($baseDir . $g2ImgPath);
} else {
    echo "[OK] El archivo de galería G2 fue eliminado físicamente.\n";
}

// Validar que no existan registros en BD
$checkService = $serviceModel->find($serviceId);
if ($checkService) {
    echo "[FAIL] El servicio sigue existiendo en la base de datos.\n";
    $errors++;
} else {
    echo "[OK] El servicio fue eliminado de la base de datos.\n";
}

$checkGallery = $galleryModel->getByService($serviceId);
if (!empty($checkGallery)) {
    echo "[FAIL] Los registros de la galería siguen existiendo en la base de datos.\n";
    $errors++;
} else {
    echo "[OK] Los registros de la galería fueron eliminados de la base de datos.\n";
}

if ($errors === 0) {
    echo "\n============================================\n";
    echo "¡TODOS LOS TESTS PASARON EXITOSAMENTE!\n";
    echo "La eliminación en cascada física funciona al 100%.\n";
    echo "============================================\n";
} else {
    echo "\n============================================\n";
    echo "SE DETECTARON ERRORES DURANTE LA PRUEBA ($errors errores).\n";
    echo "============================================\n";
}
