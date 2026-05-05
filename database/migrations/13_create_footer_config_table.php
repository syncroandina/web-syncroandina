<?php
return "
CREATE TABLE IF NOT EXISTS footer_config (
    id INT AUTO_INCREMENT PRIMARY KEY,
    about_text TEXT,
    address VARCHAR(255),
    email VARCHAR(255),
    phone VARCHAR(50),
    social_links JSON,
    copyright_text VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
";
