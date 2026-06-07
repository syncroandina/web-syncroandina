<?php
namespace App\Models;

use Core\Model;
use PDO;

class Service extends Model {
    protected $table = 'services_pages';

    public function getActive($limit = null) {
        $order = 'sort_order ASC, id ASC';
        if ($limit) {
            $order .= " LIMIT " . (int)$limit;
        }
        return $this->where('is_active', 1, '=', $order);
    }

    public function getFullDetails($id) {
        $service = $this->find($id);
        if ($service) {
            $itemModel = new ServiceItem();
            $galleryModel = new ServiceGallery();
            $service['items'] = $itemModel->getByService($id);
            $service['gallery'] = $galleryModel->getByService($id);
        }
        return $service;
    }
}
