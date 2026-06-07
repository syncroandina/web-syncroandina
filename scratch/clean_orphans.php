<?php
/**
 * Script de mantenimiento para limpiar archivos de imagen huérfanos.
 * Escanea los directorios de carga dinámica y los compara con la base de datos actual.
 */

require __DIR__ . '/../vendor/autoload.php';

// Iniciamos modelos para recopilar imágenes en uso
$dbImages = [];

try {
    // 1. Obtener imágenes de Servicios
    $serviceModel = new \App\Models\Service();
    $services = $serviceModel->all();
    foreach ($services as $service) {
        if (!empty($service['image'])) {
            $dbImages[cleanPath($service['image'])] = true;
        }
    }

    $serviceGalleryModel = new \App\Models\ServiceGallery();
    $serviceGalleries = $serviceGalleryModel->all();
    foreach ($serviceGalleries as $img) {
        if (!empty($img['image_path'])) {
            $dbImages[cleanPath($img['image_path'])] = true;
        }
    }

    // 2. Obtener imágenes de Proyectos
    $projectModel = new \App\Models\Project();
    $projects = $projectModel->all();
    foreach ($projects as $project) {
        if (!empty($project['main_image'])) {
            $dbImages[cleanPath($project['main_image'])] = true;
        }
    }

    $projectGalleryModel = new \App\Models\ProjectGallery();
    $projectGalleries = $projectGalleryModel->all();
    foreach ($projectGalleries as $img) {
        if (!empty($img['image_path'])) {
            $dbImages[cleanPath($img['image_path'])] = true;
        }
    }

    // 3. Obtener imágenes de Productos (Repuestos)
    $productModel = new \App\Models\Product();
    $products = $productModel->all();
    foreach ($products as $product) {
        if (!empty($product['main_image'])) {
            $dbImages[cleanPath($product['main_image'])] = true;
        }
    }

    $productGalleryModel = new \App\Models\ProductGallery();
    $productGalleries = $productGalleryModel->all();
    foreach ($productGalleries as $img) {
        if (!empty($img['image_path'])) {
            $dbImages[cleanPath($img['image_path'])] = true;
        }
    }

    // 4. Obtener imágenes de Blog
    $blogModel = new \App\Models\BlogPost();
    $posts = $blogModel->getAllActive(); // trae todos los posts
    foreach ($posts as $post) {
        if (!empty($post['image'])) {
            $dbImages[cleanPath($post['image'])] = true;
        }
    }

    // 5. Obtener imágenes de Sliders
    $sliderModel = new \App\Models\Slider();
    $sliders = $sliderModel->getAll();
    foreach ($sliders as $slider) {
        if (!empty($slider['image'])) {
            $dbImages[cleanPath($slider['image'])] = true;
        }
    }

    // 6. Obtener imágenes de la Galería general de inicio
    $homeGalleryModel = new \App\Models\HomeGallery();
    $homeGalleries = $homeGalleryModel->getAll();
    foreach ($homeGalleries as $img) {
        if (!empty($img['image_path'])) {
            $dbImages[cleanPath($img['image_path'])] = true;
        }
    }

} catch (\Exception $e) {
    echo "Error al conectar o consultar la base de datos: " . $e->getMessage() . "\n";
    exit(1);
}

// Directorios a escanear de forma recursiva
$basePath = realpath(__DIR__ . '/../public');
$directoriesToScan = [
    '/assets/images/services/',
    '/assets/images/projects/',
    '/assets/images/products/',
    '/assets/images/blog/',
    '/assets/images/sliders/',
    '/assets/images/gallery/'
];

$deletedCount = 0;
$scannedCount = 0;

echo "Iniciando escaneo de archivos huérfanos...\n";
echo "Imágenes válidas en Base de Datos: " . count($dbImages) . "\n\n";

foreach ($directoriesToScan as $dir) {
    $fullDir = $basePath . $dir;
    if (!is_dir($fullDir)) {
        continue;
    }
    
    $files = getFilesRecursively($fullDir);
    foreach ($files as $file) {
        $scannedCount++;
        // Obtener la ruta relativa tal como figura en BD (ej: /assets/images/services/gallery/filename.jpg)
        $relativePath = str_replace('\\', '/', str_replace($basePath, '', $file));
        
        // Excluir archivos placeholder o críticos
        if (basename($file) === '.gitkeep' || basename($file) === 'index.html' || strpos($relativePath, 'placeholder') !== false) {
            continue;
        }

        if (!isset($dbImages[cleanPath($relativePath)])) {
            echo "Eliminando archivo huérfano: " . $relativePath . "\n";
            if (unlink($file)) {
                $deletedCount++;
            } else {
                echo "ERROR al intentar eliminar: " . $relativePath . "\n";
            }
        }
    }
}

echo "\n---------------------------------------\n";
echo "Escaneo finalizado.\n";
echo "Archivos escaneados: $scannedCount\n";
echo "Archivos huérfanos eliminados: $deletedCount\n";
echo "---------------------------------------\n";

/**
 * Normaliza las rutas de la base de datos y archivos para comparar de forma precisa.
 */
function cleanPath($path) {
    $path = explode('?', $path)[0];
    return '/' . ltrim(str_replace('\\', '/', $path), '/');
}

/**
 * Función helper para listar todos los archivos recursivamente en un directorio.
 */
function getFilesRecursively($dir) {
    $files = [];
    $items = scandir($dir);
    foreach ($items as $item) {
        if ($item === '.' || $item === '..') {
            continue;
        }
        $path = $dir . DIRECTORY_SEPARATOR . $item;
        if (is_dir($path)) {
            $files = array_merge($files, getFilesRecursively($path));
        } else {
            $files[] = $path;
        }
    }
    return $files;
}
