<?php
// Migration 33: Add heading_projects and related_projects_json to services_pages table

return function($pdo) {
    try {
        $pdo->exec("ALTER TABLE services_pages ADD COLUMN heading_projects VARCHAR(255) DEFAULT 'Proyectos relacionados'");
    } catch (\PDOException $e) {}

    try {
        $pdo->exec("ALTER TABLE services_pages ADD COLUMN related_projects_json TEXT NULL");
    } catch (\PDOException $e) {}
};
