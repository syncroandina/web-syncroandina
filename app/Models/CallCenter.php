<?php
namespace App\Models;

use Core\Model;

class CallCenter extends Model {
    protected $table = 'call_center_contacts';

    public function getActive() {
        // order_index ASC matches existing conventions
        return $this->where('is_active', 1, '=', 'order_index ASC, id DESC');
    }

    public function getAll() {
        return $this->all('order_index ASC, id DESC');
    }
}
