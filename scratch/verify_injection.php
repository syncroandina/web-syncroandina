<?php
// Verificar la inyección de scripts en el HTML del sitio
function checkPage($url, $label) {
    echo "\n" . str_repeat('=', 70) . "\n";
    echo "VERIFICANDO: $label\n";
    echo "URL: $url\n";
    echo str_repeat('=', 70) . "\n";
    
    $context = stream_context_create([
        'http' => [
            'timeout' => 10,
            'ignore_errors' => true
        ]
    ]);
    
    $html = @file_get_contents($url, false, $context);
    
    if ($html === false) {
        echo "❌ ERROR: No se pudo cargar la página. ¿Está corriendo el servidor?\n";
        return;
    }
    
    // Buscar script global de head
    if (strpos($html, 'TEST GLOBAL HEAD') !== false) {
        echo "✅ [HEAD] Script global encontrado en el <head>\n";
    } else {
        echo "❌ [HEAD] Script global NO encontrado en el <head>\n";
    }
    
    // Buscar script de conversión
    if (strpos($html, 'TEST CONVERSION') !== false) {
        echo "✅ [CONVERSION] Script de conversión encontrado\n";
    } else {
        echo "ℹ️  [CONVERSION] Script de conversión NO encontrado (esperado si no es página de gracias)\n";
    }
}

// Verificar página principal (solo script global debe aparecer)
checkPage('http://localhost:8000/', 'Página de Inicio (/)');

// Verificar página de gracias (ambos scripts deben aparecer)
checkPage('http://localhost:8000/gracias', 'Página de Agradecimiento (/gracias)');

echo "\n¡Verificación completada!\n";
