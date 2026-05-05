<?php
namespace App\Models;

use Core\Model;
use PDO;

class MenuLink extends Model {
    protected $table = 'menu_links';

    public function getActive() {
        // Fetch all, then we will group them in PHP, or just fetch top level and their children
        $stmt = $this->db->query("SELECT * FROM {$this->table} WHERE is_active = 1 ORDER BY parent_id ASC, order_index ASC");
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Group by parent
        $tree = [];
        $children = [];
        
        foreach($results as $row) {
            if (empty($row['parent_id'])) {
                $row['children'] = [];
                $tree[$row['id']] = $row;
            } else {
                $children[] = $row;
            }
        }
        
        foreach($children as $child) {
            if(isset($tree[$child['parent_id']])) {
                $tree[$child['parent_id']]['children'][] = $child;
            }
        }
        
        return array_values($tree);
    }
    
    public function getTopLevel() {
        $stmt = $this->db->query("SELECT * FROM {$this->table} WHERE is_active = 1 AND parent_id IS NULL ORDER BY order_index ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function saveLink($id, $title, $url, $order, $parent_id = null) {
        if ($parent_id === '') $parent_id = null;
        
        if ($id) {
            $stmt = $this->db->prepare("UPDATE {$this->table} SET title=?, url=?, order_index=?, parent_id=? WHERE id=?");
            return $stmt->execute([$title, $url, $order, $parent_id, $id]);
        } else {
            $stmt = $this->db->prepare("INSERT INTO {$this->table} (title, url, order_index, parent_id) VALUES (?, ?, ?, ?)");
            return $stmt->execute([$title, $url, $order, $parent_id]);
        }
    }

    public function deleteLink($id) {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function updateOrder($id, $order) {
        $stmt = $this->db->prepare("UPDATE {$this->table} SET order_index=? WHERE id=?");
        return $stmt->execute([$order, $id]);
    }
}
