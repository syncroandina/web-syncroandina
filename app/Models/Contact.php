<?php
namespace App\Models;

use Core\Model;

class Contact extends Model {
    protected $table = 'contacts';

    // Soft delete override
    public function delete($id) {
        $stmt = $this->db->prepare("UPDATE {$this->table} SET deleted_at = NOW() WHERE id = ?");
        return $stmt->execute([$id]);
    }

    // Restore soft-deleted lead
    public function restore($id) {
        $stmt = $this->db->prepare("UPDATE {$this->table} SET deleted_at = NULL WHERE id = ?");
        return $stmt->execute([$id]);
    }

    // Force delete (permanent delete)
    public function forceDelete($id) {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
