<?php
namespace App\Models;

use Core\Model;
use PDO;

class BlogPost extends Model {
    protected $table = 'blog_posts';

    public function getLatest($limit = 3) {
        $sql = "SELECT p.*, u.name as author_name 
                FROM {$this->table} p
                LEFT JOIN users u ON p.author_id = u.id
                WHERE p.status = 'published' AND p.deleted_at IS NULL 
                ORDER BY p.published_at DESC LIMIT :limit";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
