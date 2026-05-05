<?php
namespace App\Models;

use Core\Model;

class Project extends Model {
    public function getAllActive() {
        $stmt = $this->db->query("SELECT * FROM projects WHERE is_active = 1 AND deleted_at IS NULL ORDER BY created_at DESC");
        return $stmt->fetchAll();
    }
    
    public function getLatest($limit = 3) {
        $stmt = $this->db->prepare("SELECT * FROM projects WHERE is_active = 1 AND deleted_at IS NULL ORDER BY created_at DESC LIMIT ?");
        $stmt->bindValue(1, $limit, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
