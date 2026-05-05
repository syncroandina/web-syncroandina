<?php
namespace App\Models;

use Core\Model;
use PDO;

class Service extends Model {
    protected $table = 'services_pages';

    public function getActive() {
        return $this->where('is_active', 1, '=', 'created_at DESC');
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
