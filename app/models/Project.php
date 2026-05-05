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

    public function find($id) {
        $stmt = $this->db->prepare("SELECT * FROM projects WHERE id = ? AND deleted_at IS NULL");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function save($data) {
        if (isset($data['id']) && !empty($data['id'])) {
            $id = $data['id'];
            unset($data['id']);
            $fields = implode(' = ?, ', array_keys($data)) . ' = ?';
            $stmt = $this->db->prepare("UPDATE projects SET $fields WHERE id = ?");
            return $stmt->execute(array_merge(array_values($data), [$id]));
        } else {
            $fields = implode(', ', array_keys($data));
            $placeholders = implode(', ', array_fill(0, count($data), '?'));
            $stmt = $this->db->prepare("INSERT INTO projects ($fields) VALUES ($placeholders)");
            return $stmt->execute(array_values($data));
        }
    }

    public function delete($id) {
        // Soft delete
        $stmt = $this->db->prepare("UPDATE projects SET deleted_at = CURRENT_TIMESTAMP, is_active = 0 WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
