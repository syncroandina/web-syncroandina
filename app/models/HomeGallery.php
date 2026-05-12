<?php
namespace App\Models;

use Core\Model;

class HomeGallery extends Model {
    protected $table = 'home_gallery';

    public function getAll() {
        return $this->all('order_index ASC');
    }
}
