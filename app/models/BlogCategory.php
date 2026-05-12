<?php
namespace App\Models;

use Core\Model;
use PDO;

class BlogCategory extends Model {
    protected $table = 'blog_categories';

    public function getAll() {
        $stmt = $this->db->query("SELECT * FROM {$this->table} ORDER BY name ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function findBySlug($slug) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE slug = ?");
        $stmt->execute([$slug]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
