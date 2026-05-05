<?php
return "
CREATE TABLE IF NOT EXISTS branding (
    id INT AUTO_INCREMENT PRIMARY KEY,
    primary_color VARCHAR(20) DEFAULT '#0f172a',
    secondary_color VARCHAR(20) DEFAULT '#3b82f6',
    accent_color VARCHAR(20) DEFAULT '#0ea5e9',
    font_family VARCHAR(100) DEFAULT 'Inter',
    favicon_path VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
";
