<?php
namespace App\Models;

use Core\Model;
use PDO;

class BlogPost extends Model {
    protected $table = 'blog_posts';

    public function getLatest($limit = 3) {
        $sql = "SELECT p.*, u.name as author_name, c.name as category_name 
                FROM {$this->table} p
                LEFT JOIN users u ON p.author_id = u.id
                LEFT JOIN blog_categories c ON p.category_id = c.id
                WHERE p.status = 'published' AND p.deleted_at IS NULL 
                ORDER BY p.published_at DESC LIMIT :limit";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllActive() {
        $sql = "SELECT p.*, u.name as author_name, c.name as category_name 
                FROM {$this->table} p
                LEFT JOIN users u ON p.author_id = u.id
                LEFT JOIN blog_categories c ON p.category_id = c.id
                WHERE p.deleted_at IS NULL 
                ORDER BY p.created_at DESC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPublished($limit = null, $categoryId = null, $searchTerm = null) {
        $sql = "SELECT p.*, u.name as author_name, c.name as category_name 
                FROM {$this->table} p
                LEFT JOIN users u ON p.author_id = u.id
                LEFT JOIN blog_categories c ON p.category_id = c.id
                WHERE p.status = 'published' AND p.deleted_at IS NULL ";
        
        if ($categoryId) {
            $sql .= " AND p.category_id = :category_id ";
        }

        if ($searchTerm) {
            $sql .= " AND (p.title LIKE :search OR p.excerpt LIKE :search OR p.content LIKE :search) ";
        }
        
        $sql .= " ORDER BY p.published_at DESC";
        
        if ($limit) {
            $sql .= " LIMIT " . (int)$limit;
        }
        
        $stmt = $this->db->prepare($sql);
        if ($categoryId) {
            $stmt->bindValue(':category_id', $categoryId);
        }
        if ($searchTerm) {
            $stmt->bindValue(':search', '%' . $searchTerm . '%');
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
