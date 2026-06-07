<?php
namespace App\Models;

use Core\Model;

class Project extends Model {
    protected $table = 'projects';

    public function getAllActive() {
        $stmt = $this->db->query("SELECT * FROM projects WHERE is_active = 1 AND deleted_at IS NULL ORDER BY created_at DESC");
        return $stmt->fetchAll();
    }

    public function getAllAdmin() {
        $stmt = $this->db->query("SELECT * FROM projects WHERE deleted_at IS NULL ORDER BY created_at DESC");
        return $stmt->fetchAll();
    }
    
    public function getLatest($limit = 3) {
        $stmt = $this->db->prepare("SELECT * FROM projects WHERE is_active = 1 AND deleted_at IS NULL ORDER BY created_at DESC LIMIT ?");
        $stmt->bindValue(1, $limit, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function find($id) {
        $stmt = $this->db->prepare("SELECT * FROM projects WHERE id = ? AND deleted_at IS NULL");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }


    public function delete($id) {
        // Soft delete
        $stmt = $this->db->prepare("UPDATE projects SET deleted_at = CURRENT_TIMESTAMP, is_active = 0 WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
