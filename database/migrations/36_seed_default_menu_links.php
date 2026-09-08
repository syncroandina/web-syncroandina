<?php
return function($pdo) {
    $stmtCheck = $pdo->query("SELECT COUNT(*) FROM menu_links");
    $count = $stmtCheck ? $stmtCheck->fetchColumn() : 0;
    if ($count == 0) {
        $stmt = $pdo->prepare("INSERT INTO menu_links (title, url, order_index, is_active) VALUES (?, ?, ?, 1)");
        $stmt->execute(['Inicio', '/', 1]);
        $stmt->execute(['Nosotros', '/nosotros', 2]);
        $stmt->execute(['Servicios', '/servicios', 3]);
        $stmt->execute(['Proyectos', '/proyectos', 4]);
        $stmt->execute(['Productos', '/productos', 5]);
        $stmt->execute(['Blog', '/blog', 6]);
        $stmt->execute(['Contacto', '/contacto', 7]);
    }
};
