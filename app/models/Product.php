<?php
namespace App\Models;

use Core\Model;

class Product extends Model {
    protected $table = 'products';

    public function getAllActive() {
        $stmt = $this->db->query("SELECT * FROM products WHERE is_active = 1 ORDER BY sort_order ASC, created_at DESC");
        return $stmt->fetchAll();
    }
    
    public function findBySlug($slug) {
        $stmt = $this->db->prepare("SELECT * FROM products WHERE slug = ? AND is_active = 1");
        $stmt->execute([$slug]);
        return $stmt->fetch();
    }
    
    public function getFullDetails($id) {
        $product = $this->find($id);
        if ($product) {
            $galleryModel = new ProductGallery();
            $product['gallery'] = $galleryModel->getByProduct($id);
        }
        return $product;
    }
}
