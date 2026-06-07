<?php
/**
 * Script de prueba de integración para validar la renderización del 404.
 */

// Simulamos los valores del servidor
$_SERVER['REQUEST_URI'] = '/ruta-no-existe-para-test';
$_SERVER['REQUEST_METHOD'] = 'GET';
$_SERVER['HTTP_HOST'] = 'localhost:8000';
$_SERVER['SERVER_PORT'] = '8000';

// Habilitamos buffering
ob_start();

try {
    // Requerir el bootstrap e index
    require __DIR__ . '/../public/index.php';
} catch (\Exception $e) {
    echo "Excepción capturada: " . $e->getMessage() . "\n";
}

$output = ob_get_clean();

// Validar que se muestre el HTML y el texto del 404
if (strpos($output, '404') !== false && strpos($output, 'Página No Encontrada') !== false && strpos($output, 'Volver al Inicio') !== false) {
    echo "============================================\n";
    echo "¡EL TEST DE RENDERIZADO 404 PASÓ EXITOSAMENTE!\n";
    echo "Se renderiza el HTML premium con el layout de cabecera y pie de página.\n";
    echo "============================================\n";
} else {
    echo "============================================\n";
    echo "ERROR: El renderizado 404 no generó la estructura esperada.\n";
    echo "Longitud de salida: " . strlen($output) . "\n";
    echo "Fragmento de la salida:\n" . substr($output, 0, 500) . "\n";
    echo "============================================\n";
    exit(1);
}
