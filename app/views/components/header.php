<!DOCTYPE html>
<html lang="es" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Syncro Andina | Innovación Corporativa') ?></title>
    <meta name="description" content="<?= htmlspecialchars($description ?? 'Syncro Andina: Desarrollo de software premium, transformación digital y modernización cloud para corporaciones.') ?>">
    <meta name="keywords" content="transformación digital, desarrollo web, software a medida, aplicaciones corporativas">
    <meta name="author" content="Syncro Andina">
    
    <!-- Open Graph (Redes Sociales) -->
    <meta property="og:title" content="<?= htmlspecialchars($title ?? 'Syncro Andina') ?>">
    <meta property="og:description" content="<?= htmlspecialchars($description ?? 'Soluciones integrales diseñadas para impulsar el crecimiento corporativo.') ?>">
    <meta property="og:type" content="website">
    <!-- Tailwind CSS CDN para la fase de prototipado -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#0f172a',
                        secondary: '#3b82f6',
                        accent: '#0ea5e9'
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="antialiased text-gray-800 bg-gray-50">
