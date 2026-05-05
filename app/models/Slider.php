<?php
namespace App\Models;

use Core\Model;

class Slider extends Model {
    public function getActive() {
        $stmt = $this->db->query("SELECT * FROM sliders WHERE is_active = 1 ORDER BY order_index ASC");
        return $stmt->fetchAll();
    }
}
