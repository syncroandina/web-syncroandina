<?php
return function($pdo) {
    $sql = "CREATE TABLE IF NOT EXISTS call_center_contacts (
        id INT AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(255) NOT NULL,
        subtitle VARCHAR(255) NULL,
        type VARCHAR(50) DEFAULT 'whatsapp',
        phone_number VARCHAR(50) NOT NULL,
        order_index INT DEFAULT 0,
        is_active TINYINT(1) DEFAULT 1,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";

    $pdo->exec($sql);

    // Seed default call center contact if table empty
    $stmt = $pdo->query("SELECT COUNT(*) FROM call_center_contacts");
    if ($stmt->fetchColumn() == 0) {
        $pdo->exec("INSERT INTO call_center_contacts (title, subtitle, type, phone_number, order_index, is_active) 
            VALUES ('Atención Comercial', 'Ventas y Cotizaciones', 'whatsapp', '+51 987 654 321', 1, 1);");
    }
};
