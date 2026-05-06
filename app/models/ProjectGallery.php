<?php
namespace App\Models;

use Core\Model;

class ProjectGallery extends Model {
    protected $table = 'gallery';

    public function getByProject($projectId) {
        return $this->where('project_id', $projectId, '=', 'order_index ASC');
    }

    public function deleteByProject($projectId) {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE project_id = ?");
        return $stmt->execute([$projectId]);
    }
}
