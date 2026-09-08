<?php
namespace App\Models;

use Core\Model;

class CallCenter extends Model {
    protected $table = 'call_center_contacts';

    public function getActive() {
        try {
            return $this->where('is_active', 1, '=', 'order_index ASC, id DESC');
        } catch (\Throwable $e) {
            return [];
        }
    }

    public function getAll() {
        try {
            return $this->all('order_index ASC, id DESC');
        } catch (\Throwable $e) {
            return [];
        }
    }
}
