<?php
return function($pdo) {
    try {
        $pdo->exec("ALTER TABLE services_pages ADD COLUMN enable_seo_clones TINYINT(1) DEFAULT 0 AFTER is_active");
    } catch (\PDOException $e) {
        // Column might already exist
    }
};
