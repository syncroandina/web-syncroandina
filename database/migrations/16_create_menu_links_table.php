<?php
return "
CREATE TABLE IF NOT EXISTS menu_links (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    url VARCHAR(255) NOT NULL,
    order_index INT DEFAULT 0,
    is_active BOOLEAN DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT IGNORE INTO menu_links (title, url, order_index) VALUES 
('Inicio', '/', 1),
('La Empresa', '/about', 2),
('Servicios', '/services', 3),
('Proyectos', '/projects', 4),
('Blog', '/blog', 5),
('Contacto', '/contact', 6);
";
