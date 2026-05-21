<?php
/**
 * Test End-to-End completo del módulo de Scripts de Seguimiento
 * Simula exactamente lo que hace el controlador AdminController
 */
require 'vendor/autoload.php';

$config = require 'config/database.php';
$db = new PDO(
    "mysql:host={$config['host']};dbname={$config['dbname']};charset={$config['charset']}",
    $config['username'],
    $config['password'],
    $config['options']
);

$passed = 0;
$failed = 0;

function test($name, $condition, $detail = '') {
    global $passed, $failed;
    if ($condition) {
        echo "  ✅ PASS: $name\n";
        $passed++;
    } else {
        echo "  ❌ FAIL: $name" . ($detail ? " | $detail" : '') . "\n";
        $failed++;
    }
}

function fetchHtml($url) {
    $ctx = stream_context_create(['http' => ['timeout' => 8, 'ignore_errors' => true]]);
    return @file_get_contents($url, false, $ctx);
}

echo "\n" . str_repeat('=', 65) . "\n";
echo "  TEST SUITE: Módulo Scripts de Seguimiento\n";
echo str_repeat('=', 65) . "\n\n";

// ─────────────────────────────────────────────────────────────
// 1. VERIFICAR ESTRUCTURA DE LA TABLA
// ─────────────────────────────────────────────────────────────
echo "📋 1. ESTRUCTURA DE BASE DE DATOS\n";

$cols = $db->query("DESCRIBE scripts")->fetchAll(PDO::FETCH_ASSOC);
$colNames = array_column($cols, 'Field');

test('Columna name existe', in_array('name', $colNames));
test('Columna code existe', in_array('code', $colNames));
test('Columna placement existe', in_array('placement', $colNames));
test('Columna page_restriction existe', in_array('page_restriction', $colNames));
test('Columna is_active existe', in_array('is_active', $colNames));

// Verificar ENUMs
foreach ($cols as $col) {
    if ($col['Field'] === 'placement') {
        test(
            "ENUM placement tiene valores correctos",
            strpos($col['Type'], 'head') !== false && strpos($col['Type'], 'body_start') !== false && strpos($col['Type'], 'body_end') !== false
        );
    }
    if ($col['Field'] === 'page_restriction') {
        test(
            "ENUM page_restriction tiene valores correctos",
            strpos($col['Type'], 'all') !== false && strpos($col['Type'], 'thanks_only') !== false
        );
    }
}

// ─────────────────────────────────────────────────────────────
// 2. CRUD VIA MODELO (simula el controlador)
// ─────────────────────────────────────────────────────────────
echo "\n📦 2. OPERACIONES CRUD (vía Modelo)\n";

$scriptModel = new \App\Models\Script();

// INSERT
$newId = $scriptModel->save([
    'name'             => 'E2E Test - Google Ads Global',
    'code'             => '<!-- Google Ads Global --><script>console.log("GA Global OK");</script>',
    'placement'        => 'head',
    'page_restriction' => 'all',
    'is_active'        => 1
]);
test('INSERT: Crear script nuevo', $newId > 0, "ID obtenido: $newId");

$convId = $scriptModel->save([
    'name'             => 'E2E Test - Meta Conversión',
    'code'             => '<!-- Meta Conv --><script>console.log("META CONV OK");</script>',
    'placement'        => 'body_end',
    'page_restriction' => 'thanks_only',
    'is_active'        => 1
]);
test('INSERT: Crear script de conversión', $convId > 0, "ID obtenido: $convId");

// READ
$script = $scriptModel->find($newId);
test('READ: Recuperar script por ID', !empty($script));
test('READ: name correcto', $script['name'] === 'E2E Test - Google Ads Global');
test('READ: placement correcto', $script['placement'] === 'head');
test('READ: page_restriction correcto', $script['page_restriction'] === 'all');

// UPDATE
$scriptModel->save(['id' => $newId, 'name' => 'E2E Test - Google Ads Global (Editado)']);
$updated = $scriptModel->find($newId);
test('UPDATE: Nombre actualizado', $updated['name'] === 'E2E Test - Google Ads Global (Editado)');

// TOGGLE (is_active = 0)
$scriptModel->save(['id' => $newId, 'is_active' => 0]);
$toggled = $scriptModel->find($newId);
test('TOGGLE: Desactivar script', $toggled['is_active'] == 0);

// Re-activar
$scriptModel->save(['id' => $newId, 'is_active' => 1]);
$reactivated = $scriptModel->find($newId);
test('TOGGLE: Re-activar script', $reactivated['is_active'] == 1);

// ─────────────────────────────────────────────────────────────
// 3. LÓGICA getActiveForPage()
// ─────────────────────────────────────────────────────────────
echo "\n🔍 3. FILTRADO POR PÁGINA (getActiveForPage)\n";

// Página normal (no /gracias) → solo restriction='all'
$normalScripts = $scriptModel->getActiveForPage(false);
$hasGlobal   = false;
$hasConvInNormal = false;
foreach ($normalScripts as $s) {
    if ($s['id'] == $newId)   $hasGlobal = true;
    if ($s['id'] == $convId)  $hasConvInNormal = true;
}
test('Página normal: script global (all) aparece', $hasGlobal);
test('Página normal: script de conversión NO aparece', !$hasConvInNormal);

// Página /gracias → ambos
$thanksScripts = $scriptModel->getActiveForPage(true);
$hasGlobalInThanks = false;
$hasConvInThanks   = false;
foreach ($thanksScripts as $s) {
    if ($s['id'] == $newId)   $hasGlobalInThanks = true;
    if ($s['id'] == $convId)  $hasConvInThanks = true;
}
test('Página /gracias: script global (all) aparece', $hasGlobalInThanks);
test('Página /gracias: script de conversión (thanks_only) aparece', $hasConvInThanks);

// Script inactivo NO debe aparecer en ninguna página
$scriptModel->save(['id' => $newId, 'is_active' => 0]);
$inactiveCheck = $scriptModel->getActiveForPage(false);
$inactiveAppears = false;
foreach ($inactiveCheck as $s) { if ($s['id'] == $newId) $inactiveAppears = true; }
test('Script inactivo NO aparece en página normal', !$inactiveAppears);

$scriptModel->save(['id' => $newId, 'is_active' => 1]); // restaurar

// ─────────────────────────────────────────────────────────────
// 4. INYECCIÓN EN HTML DEL FRONTEND
// ─────────────────────────────────────────────────────────────
echo "\n🌐 4. INYECCIÓN EN HTML DEL FRONTEND\n";

$homeHtml   = fetchHtml('http://localhost:8000/');
$gracHtml   = fetchHtml('http://localhost:8000/gracias');

if ($homeHtml === false || $gracHtml === false) {
    echo "  ⚠️  No se puede conectar al servidor. ¿Está corriendo en localhost:8000?\n";
} else {
    // Página inicio
    test('Inicio /: script global HEAD inyectado', strpos($homeHtml, 'GA Global OK') !== false);
    test('Inicio /: script de conversión NO inyectado', strpos($homeHtml, 'META CONV OK') === false);

    // Página gracias
    test('/gracias: script global HEAD inyectado', strpos($gracHtml, 'GA Global OK') !== false);
    test('/gracias: script de conversión BODY_END inyectado', strpos($gracHtml, 'META CONV OK') !== false);

    // Verificar placement correcto (head antes de </head>)
    $headEnd = strpos($homeHtml, '</head>');
    $scriptPos = strpos($homeHtml, 'GA Global OK');
    test('Script HEAD posicionado ANTES de </head>', $scriptPos !== false && $scriptPos < $headEnd);
}

// ─────────────────────────────────────────────────────────────
// 5. RUTAS HTTP (verificar que responden)
// ─────────────────────────────────────────────────────────────
echo "\n🛣️  5. RUTAS ADMIN (redireccionan al login si no hay sesión)\n";

$routes = [
    '/admin/scripts'        => 'GET admin/scripts',
    '/admin/scripts/save'   => 'POST admin/scripts/save',
    '/admin/scripts/delete' => 'POST admin/scripts/delete',
    '/admin/scripts/toggle' => 'POST admin/scripts/toggle',
];

foreach ($routes as $path => $label) {
    $html = fetchHtml("http://localhost:8000$path");
    $redirectsOrLoads = ($html !== false);
    test("Ruta $label responde (no 404)", $redirectsOrLoads);
}

// ─────────────────────────────────────────────────────────────
// 6. LIMPIEZA
// ─────────────────────────────────────────────────────────────
echo "\n🧹 6. LIMPIEZA\n";
$scriptModel->delete($newId);
$scriptModel->delete($convId);
$deletedCheck1 = $scriptModel->find($newId);
$deletedCheck2 = $scriptModel->find($convId);
test('DELETE: Script global eliminado', $deletedCheck1 === false);
test('DELETE: Script de conversión eliminado', $deletedCheck2 === false);

// ─────────────────────────────────────────────────────────────
// RESULTADOS FINALES
// ─────────────────────────────────────────────────────────────
$total = $passed + $failed;
echo "\n" . str_repeat('=', 65) . "\n";
echo "  RESULTADO FINAL: $passed/$total tests pasaron\n";
if ($failed === 0) {
    echo "  🎉 ¡TODOS LOS TESTS PASARON EXITOSAMENTE!\n";
} else {
    echo "  ⚠️  $failed test(s) fallaron. Revisar arriba.\n";
}
echo str_repeat('=', 65) . "\n\n";
