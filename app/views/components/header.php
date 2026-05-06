<!DOCTYPE html>
<html lang="es" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Syncro Andina | Innovación Corporativa') ?></title>
    <meta name="description" content="<?= htmlspecialchars($description ?? 'Syncro Andina: Desarrollo de software premium, transformación digital y modernización cloud para corporaciones.') ?>">
    <meta name="keywords" content="<?= htmlspecialchars($keywords ?? 'transformación digital, desarrollo web, software a medida, aplicaciones corporativas') ?>">
    <meta name="author" content="Syncro Andina">
    
    <?php
    $settingModel = new \App\Models\Setting();
    $settings = $settingModel->getAll();
    $faviconUrl = $settings['favicon_url'] ?? null;
    
    $basePath = dirname($_SERVER['SCRIPT_NAME']);
    $basePath = ($basePath === '/' || $basePath === '\\') ? '' : $basePath;

    if ($faviconUrl): ?>
        <link rel="icon" href="<?= asset($faviconUrl) ?>">
    <?php endif; ?>

    <!-- Fuentes Dinámicas (Google Fonts) -->
    <?php 
    $fonts = array_unique([
        $settings['font_h1'] ?? 'Inter',
        $settings['font_h2'] ?? 'Inter',
        $settings['font_h3'] ?? 'Inter',
        $settings['font_h4'] ?? 'Inter',
        $settings['font_h5'] ?? 'Inter',
        $settings['font_h6'] ?? 'Inter',
        $settings['font_body'] ?? 'Inter'
    ]);
    $fontFamilyString = implode('|', array_map(function($f) { return str_replace(' ', '+', $f) . ':wght@300;400;500;600;700;800'; }, $fonts));
    ?>
    <link href="https://fonts.googleapis.com/css2?family=<?= $fontFamilyString ?>&display=swap" rel="stylesheet">
    
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    
    <!-- Estilos Globales Dinámicos -->
    <link rel="stylesheet" href="<?= asset('assets/css/theme.css') ?>?v=<?= time() ?>">
    
    <!-- Open Graph (Redes Sociales) -->
    <meta property="og:title" content="<?= htmlspecialchars($title ?? 'Syncro Andina') ?>">
    <meta property="og:description" content="<?= htmlspecialchars($description ?? 'Soluciones integrales diseñadas para impulsar el crecimiento corporativo.') ?>">
    <meta property="og:type" content="website">
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '<?= $settings['color_primary'] ?? '#0f172a' ?>',
                        secondary: '<?= $settings['color_secondary'] ?? '#3b82f6' ?>',
                        accent: '<?= $settings['color_accent'] ?? '#0ea5e9' ?>',
                        'light-gray': '<?= $settings['color_light_gray'] ?? '#f8fafc' ?>',
                        'gray-medium': '<?= $settings['color_gray'] ?? '#64748b' ?>',
                        'dark-gray': '<?= $settings['color_dark_gray'] ?? '#1e293b' ?>'
                    },
                    fontFamily: {
                        sans: ['<?= $settings['font_body'] ?? 'Inter' ?>', 'sans-serif'],
                        headings: ['<?= $settings['font_h1'] ?? 'Inter' ?>', 'sans-serif']
                    }
                }
            }
        }
    </script>
    <style>
        :root {
            --primary: <?= $settings['color_primary'] ?? '#0f172a' ?>;
            --secondary: <?= $settings['color_secondary'] ?? '#3b82f6' ?>;
            --accent: <?= $settings['color_accent'] ?? '#0ea5e9' ?>;
        }
    </style>
</head>
<body class="antialiased text-gray-800 bg-gray-50">
