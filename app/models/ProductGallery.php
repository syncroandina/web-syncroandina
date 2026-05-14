<?php
namespace App\Models;

use Core\Model;

class ProductGallery extends Model {
    protected $table = 'product_gallery';

    public function getByProduct($productId) {
        $stmt = $this->db->prepare("SELECT * FROM product_gallery WHERE product_id = ? ORDER BY order_index ASC, created_at ASC");
        $stmt->execute([$productId]);
        return $stmt->fetchAll();
    }

    public function deleteByProduct($productId) {
        $stmt = $this->db->prepare("DELETE FROM product_gallery WHERE product_id = ?");
        return $stmt->execute([$productId]);
    }
}
