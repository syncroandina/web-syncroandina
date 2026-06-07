<?php
namespace App\Models;

use Core\Model;

class Product extends Model {
    protected $table = 'products';

    public function getAllActive($categoryId = null) {
        if ($categoryId !== null) {
            $stmt = $this->db->prepare("SELECT p.*, c.name as category_name, c.slug as category_slug 
                                       FROM products p 
                                       LEFT JOIN product_categories c ON p.category_id = c.id 
                                       WHERE p.is_active = 1 AND p.category_id = ? 
                                       ORDER BY p.sort_order ASC, p.created_at DESC");
            $stmt->execute([$categoryId]);
        } else {
            $stmt = $this->db->query("SELECT p.*, c.name as category_name, c.slug as category_slug 
                                     FROM products p 
                                     LEFT JOIN product_categories c ON p.category_id = c.id 
                                     WHERE p.is_active = 1 
                                     ORDER BY p.sort_order ASC, p.created_at DESC");
        }
        return $stmt->fetchAll();
    }
    
    public function findBySlug($slug) {
        $stmt = $this->db->prepare("SELECT p.*, c.name as category_name, c.slug as category_slug 
                                    FROM products p 
                                    LEFT JOIN product_categories c ON p.category_id = c.id 
                                    WHERE p.slug = ? AND p.is_active = 1");
        $stmt->execute([$slug]);
        return $stmt->fetch();
    }
    
    public function getFullDetails($id) {
        $stmt = $this->db->prepare("SELECT p.*, c.name as category_name 
                                    FROM products p 
                                    LEFT JOIN product_categories c ON p.category_id = c.id 
                                    WHERE p.id = ?");
        $stmt->execute([$id]);
        $product = $stmt->fetch();
        if ($product) {
            $galleryModel = new ProductGallery();
            $product['gallery'] = $galleryModel->getByProduct($id);
        }
        return $product;
    }
}
