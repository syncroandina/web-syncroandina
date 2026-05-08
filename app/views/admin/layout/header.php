<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Admin Dashboard') ?> - Syncro Andina</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <?php
    $settingModel = new \App\Models\Setting();
    $adminSettings = $settingModel->getAll();
    ?>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '<?= $adminSettings['color_primary'] ?? '#0f172a' ?>',
                        secondary: '<?= $adminSettings['color_secondary'] ?? '#3b82f6' ?>',
                        accent: '<?= $adminSettings['color_accent'] ?? '#0ea5e9' ?>',
                        red: {
                            500: '<?= $adminSettings['color_accent'] ?? '#ef4444' ?>',
                            600: '<?= $adminSettings['color_accent'] ?? '#dc2626' ?>',
                            700: '<?= $adminSettings['color_secondary'] ?? '#b91c1c' ?>',
                            800: '<?= $adminSettings['color_secondary'] ?? '#991b1b' ?>'
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        :root {
            --primary: <?= $adminSettings['color_primary'] ?? '#0f172a' ?>;
            --secondary: <?= $adminSettings['color_secondary'] ?? '#3b82f6' ?>;
            --accent: <?= $adminSettings['color_accent'] ?? '#0ea5e9' ?>;
        }
        body { font-family: 'Inter', sans-serif; }
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background-color: rgba(255, 255, 255, 0.1); border-radius: 10px; }
        
        .modal-scrollbar::-webkit-scrollbar { width: 8px; }
        .modal-scrollbar::-webkit-scrollbar-track { background: transparent; margin: 16px 0; }
        .modal-scrollbar::-webkit-scrollbar-thumb { background: rgba(0, 0, 0, 0.15); background-clip: padding-box; border: 2px solid transparent; border-radius: 10px; }
        .modal-scrollbar::-webkit-scrollbar-thumb:hover { background: rgba(0, 0, 0, 0.3); background-clip: padding-box; border: 2px solid transparent; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 antialiased" x-data="{ sidebarOpen: true }">
    <div class="flex h-screen overflow-hidden">
