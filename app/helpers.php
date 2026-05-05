<?php

function asset($path) {
    $base = dirname($_SERVER['SCRIPT_NAME']);
    $base = ($base === '/' || $base === '\\') ? '' : $base;
    $base = str_replace('\\', '/', $base);
    
    // Si la ruta ya empieza con el base path, no lo repetimos
    if ($base !== '' && strpos($path, $base) === 0) {
        $path = substr($path, strlen($base));
    }

    $path = '/' . ltrim($path, '/');
    return $base . $path;
}

function url($path = '') {
    $base = dirname($_SERVER['SCRIPT_NAME']);
    $base = ($base === '/' || $base === '\\') ? '' : $base;
    $base = str_replace('\\', '/', $base);
    
    $path = '/' . ltrim($path, '/');
    return $base . $path;
}
