<?php
namespace App\Models;

use Core\Model;

class ClientLogo extends Model {
    protected $table = 'clients_logos';

    public function getActive() {
        return $this->db->query("
            SELECT * FROM {$this->table} 
            WHERE is_active = 1 
            ORDER BY sort_order ASC, id DESC
        ")->fetchAll(\PDO::FETCH_ASSOC);
    }
}
