<?php
namespace App\Models;

use Core\Model;
use PDO;

class Location extends Model {
    protected $table = 'locations';

    public function ensureTableExists() {
        $this->db->exec("
            CREATE TABLE IF NOT EXISTS locations (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(150) NOT NULL,
                slug VARCHAR(150) NOT NULL UNIQUE,
                parent_id INT DEFAULT NULL,
                type ENUM('country', 'department', 'district') DEFAULT 'country',
                order_index INT DEFAULT 0,
                is_active TINYINT(1) DEFAULT 1,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                KEY idx_parent_id (parent_id),
                KEY idx_slug (slug),
                KEY idx_type (type)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ");

        try {
            $this->db->exec("ALTER TABLE locations ADD COLUMN type ENUM('country', 'department', 'district') DEFAULT 'country' AFTER parent_id");
        } catch (\PDOException $e) {}
    }

    public function getCountries() {
        $stmt = $this->db->query("
            SELECT * FROM {$this->table} 
            WHERE (parent_id IS NULL OR parent_id = 0) 
            ORDER BY order_index ASC, name ASC
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getDepartmentsByCountry($countryId) {
        $stmt = $this->db->prepare("
            SELECT * FROM {$this->table} 
            WHERE parent_id = ? AND (type = 'department' OR type IS NULL) 
            ORDER BY order_index ASC, name ASC
        ");
        $stmt->execute([(int)$countryId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getDistrictsByDepartment($departmentId) {
        $stmt = $this->db->prepare("
            SELECT * FROM {$this->table} 
            WHERE parent_id = ? AND type = 'district' 
            ORDER BY order_index ASC, name ASC
        ");
        $stmt->execute([(int)$departmentId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllDepartments() {
        $stmt = $this->db->query("
            SELECT d.*, c.name as country_name 
            FROM {$this->table} d 
            LEFT JOIN {$this->table} c ON d.parent_id = c.id 
            WHERE d.type = 'department' OR (d.parent_id IS NOT NULL AND d.parent_id != 0) 
            ORDER BY c.name ASC, d.name ASC
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllHierarchy() {
        $countries = $this->getCountries();
        foreach ($countries as &$country) {
            $country['departments'] = $this->getDepartmentsByCountry($country['id']);
            foreach ($country['departments'] as &$dept) {
                $dept['districts'] = $this->getDistrictsByDepartment($dept['id']);
            }
        }
        return $countries;
    }

    public function getAllActiveFlat() {
        $stmt = $this->db->query("
            SELECT l.*, p.name as parent_name 
            FROM {$this->table} l 
            LEFT JOIN {$this->table} p ON l.parent_id = p.id 
            WHERE l.is_active = 1 
            ORDER BY FIELD(l.type, 'country', 'department', 'district') ASC, l.order_index ASC, l.name ASC
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById($id) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = ?");
        $stmt->execute([(int)$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findBySlug($slug) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE slug = ?");
        $stmt->execute([$slug]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function save($data) {
        $this->ensureTableExists();

        $id = isset($data['id']) && !empty($data['id']) ? (int)$data['id'] : null;
        $name = trim($data['name'] ?? '');
        $parentId = isset($data['parent_id']) && !empty($data['parent_id']) ? (int)$data['parent_id'] : null;
        $type = $data['type'] ?? null;
        $isActive = isset($data['is_active']) ? (int)$data['is_active'] : 1;
        $orderIndex = isset($data['order_index']) ? (int)$data['order_index'] : 0;

        if (empty($name)) {
            return false;
        }

        // Auto-determine type if not provided
        if (empty($type)) {
            if (empty($parentId)) {
                $type = 'country';
            } else {
                $parent = $this->findById($parentId);
                if ($parent) {
                    if (empty($parent['parent_id']) || $parent['type'] === 'country') {
                        $type = 'department';
                    } else {
                        $type = 'district';
                    }
                } else {
                    $type = 'department';
                }
            }
        }

        // Generate Slug
        $baseSlug = $this->slugify($name);
        $slug = $baseSlug;

        if ($id) {
            // Update
            $existing = $this->findById($id);
            if (!$existing) return false;

            $stmtCheck = $this->db->prepare("SELECT id FROM {$this->table} WHERE slug = ? AND id != ?");
            $stmtCheck->execute([$slug, $id]);
            if ($stmtCheck->fetch()) {
                $slug = $baseSlug . '-' . time();
            }

            $stmt = $this->db->prepare("
                UPDATE {$this->table} 
                SET name = ?, slug = ?, parent_id = ?, type = ?, is_active = ? 
                WHERE id = ?
            ");
            return $stmt->execute([$name, $slug, $parentId, $type, $isActive, $id]);
        } else {
            // Insert
            $stmtCheck = $this->db->prepare("SELECT id FROM {$this->table} WHERE slug = ?");
            $stmtCheck->execute([$slug]);
            if ($stmtCheck->fetch()) {
                $slug = $baseSlug . '-' . time();
            }

            $stmt = $this->db->prepare("
                INSERT INTO {$this->table} (name, slug, parent_id, type, order_index, is_active) 
                VALUES (?, ?, ?, ?, ?, ?)
            ");
            return $stmt->execute([$name, $slug, $parentId, $type, $orderIndex, $isActive]);
        }
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE id = ?");
        return $stmt->execute([(int)$id]);
    }

    public function toggleStatus($id) {
        $item = $this->findById($id);
        if (!$item) return false;
        $newStatus = $item['is_active'] ? 0 : 1;
        $stmt = $this->db->prepare("UPDATE {$this->table} SET is_active = ? WHERE id = ?");
        return $stmt->execute([$newStatus, (int)$id]);
    }

    public function reorder($orderIds) {
        if (!is_array($orderIds)) return false;
        $stmt = $this->db->prepare("UPDATE {$this->table} SET order_index = ? WHERE id = ?");
        foreach ($orderIds as $index => $id) {
            $stmt->execute([$index + 1, (int)$id]);
        }
        return true;
    }

    private function slugify($text) {
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        $text = preg_replace('~[^-\w]+~', '', $text);
        $text = trim($text, '-');
        $text = preg_replace('~-+~', '-', $text);
        $text = strtolower($text);
        return empty($text) ? 'lugar' : $text;
    }
}
