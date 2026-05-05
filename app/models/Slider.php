<?php
namespace App\Models;

use Core\Model;

class Slider extends Model {
    protected $table = 'sliders';

    public function getActive() {
        return $this->where('is_active', 1, '=', 'order_index ASC');
    }

    public function getAll() {
        return $this->all('order_index ASC');
    }
}
