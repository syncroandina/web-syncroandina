<?php
namespace App\Models;

use Core\Model;

class ServiceItem extends Model {
    protected $table = 'service_items';

    public function getByService($serviceId) {
        return $this->where('service_id', $serviceId, '=', 'sort_order ASC');
    }

    public function deleteByService($serviceId) {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE service_id = ?");
        return $stmt->execute([$serviceId]);
    }
}
