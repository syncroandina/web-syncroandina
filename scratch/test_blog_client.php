<?php
/**
 * Script de prueba de integración para validar la eliminación de archivos en Blog y Clientes.
 */

require __DIR__ . '/../vendor/autoload.php';

echo "Iniciando prueba de borrado físico en Blog y Clientes...\n";

$blogModel = new \App\Models\BlogPost();
$clientLogoModel = new \App\Models\ClientLogo();

// Rutas de archivos de prueba
$baseDir = __DIR__ . '/../public';
$blogImgPath = '/assets/images/blog/dummy_blog.jpg';
$logoImgPath = '/assets/images/branding/dummy_logo.jpg';

// Asegurar que existan las carpetas
@mkdir(dirname($baseDir . $blogImgPath), 0755, true);
@mkdir(dirname($baseDir . $logoImgPath), 0755, true);

// Crear archivos físicos ficticios
file_put_contents($baseDir . $blogImgPath, 'dummy blog image data');
file_put_contents($baseDir . $logoImgPath, 'dummy logo image data');

// Validar creación de archivos
if (file_exists($baseDir . $blogImgPath) && file_exists($baseDir . $logoImgPath)) {
    echo "[OK] Archivos de prueba creados físicamente en el disco.\n";
} else {
    echo "[FAIL] Error al crear archivos físicos en disco.\n";
    exit(1);
}

// Insertar registros en BD
try {
    // Registro de blog
    $postId = $blogModel->save([
        'title' => 'Blog Test Borrado',
        'slug' => 'blog-test-borrado',
        'excerpt' => 'Extracto de prueba',
        'content' => 'Contenido de prueba',
        'image' => $blogImgPath,
        'status' => 'draft'
    ]);

    // Registro de logo de cliente
    $logoId = $clientLogoModel->save([
        'name' => 'Cliente Test Borrado',
        'logo_path' => $logoImgPath,
        'is_active' => 0,
        'sort_order' => 1
    ]);

    echo "[OK] Registros dummy guardados en la BD (Post ID: $postId, Logo ID: $logoId).\n";
} catch (\Exception $e) {
    echo "[FAIL] Error al escribir en base de datos: " . $e->getMessage() . "\n";
    @unlink($baseDir . $blogImgPath);
    @unlink($baseDir . $logoImgPath);
    exit(1);
}

// Simular eliminación de Post
echo "Simulando eliminación del post de blog...\n";
$post = $blogModel->find($postId);
if ($post) {
    // 1. Eliminar archivo físico de la portada
    if (!empty($post['image'])) {
        \Core\FileHelper::delete($post['image']);
    }
    // 2. Aplicar soft delete
    $blogModel->save([
        'id' => $postId,
        'deleted_at' => date('Y-m-d H:i:s')
    ]);
    echo "[OK] Lógica de borrado de post completada.\n";
} else {
    echo "[FAIL] No se pudo encontrar el post recién guardado.\n";
}

// Simular eliminación de Logo de Cliente
echo "Simulando eliminación del logo de cliente...\n";
$logo = $clientLogoModel->find($logoId);
if ($logo) {
    // 1. Eliminar archivo físico
    if (!empty($logo['logo_path'])) {
        \Core\FileHelper::delete($logo['logo_path']);
    }
    // 2. Eliminar registro en BD
    $clientLogoModel->delete($logoId);
    echo "[OK] Lógica de borrado de logo completada.\n";
} else {
    echo "[FAIL] No se pudo encontrar el logo recién guardado.\n";
}

// VALIDAR RESULTADOS
$errors = 0;

// Validar que los archivos ya no estén en disco
if (file_exists($baseDir . $blogImgPath)) {
    echo "[FAIL] La imagen de portada del blog sigue existiendo en el disco.\n";
    $errors++;
    @unlink($baseDir . $blogImgPath);
} else {
    echo "[OK] La imagen de portada del blog fue eliminada físicamente.\n";
}

if (file_exists($baseDir . $logoImgPath)) {
    echo "[FAIL] El logo del cliente sigue existiendo en el disco.\n";
    $errors++;
    @unlink($baseDir . $logoImgPath);
} else {
    echo "[OK] El logo del cliente fue eliminado físicamente.\n";
}

// Validar que el post tenga soft-delete
$checkPost = $blogModel->find($postId);
if ($checkPost && !empty($checkPost['deleted_at'])) {
    echo "[OK] El post del blog está marcado correctamente como eliminado (soft-delete).\n";
} else {
    echo "[FAIL] El post del blog no tiene la marca de eliminado (soft-delete).\n";
    $errors++;
}

// Validar que el logo no exista
$checkLogo = $clientLogoModel->find($logoId);
if ($checkLogo) {
    echo "[FAIL] El logo del cliente sigue existiendo en la base de datos.\n";
    $errors++;
} else {
    echo "[OK] El logo del cliente fue eliminado de la base de datos.\n";
}

// Limpiar el registro del blog en BD para no dejar basura de pruebas
try {
    $blogModel->db->exec("DELETE FROM blog_posts WHERE id = $postId");
    echo "[OK] Registro de post temporal purgado físicamente de la base de datos.\n";
} catch (\Exception $e) {
    // Ignorar si falla
}

if ($errors === 0) {
    echo "\n============================================\n";
    echo "¡TODOS LOS TESTS DE BLOG Y CLIENTES PASARON EXITOSAMENTE!\n";
    echo "La eliminación física de imágenes funciona al 100%.\n";
    echo "============================================\n";
} else {
    echo "\n============================================\n";
    echo "SE DETECTARON ERRORES DURANTE LA PRUEBA ($errors errores).\n";
    echo "============================================\n";
}
