<?php
namespace App\Models;

use Core\Model;
use PDO;

class Setting extends Model {
    protected $table = 'settings';

    public function getAll() {
        $stmt = $this->db->query("SELECT setting_key, setting_value FROM {$this->table}");
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $settings = [];
        foreach($results as $row) {
            $settings[$row['setting_key']] = $row['setting_value'];
        }
        return $settings;
    }

    public function get($key, $default = null) {
        $stmt = $this->db->prepare("SELECT setting_value FROM {$this->table} WHERE setting_key = ?");
        $stmt->execute([$key]);
        $result = $stmt->fetchColumn();
        return $result !== false ? $result : $default;
    }

    public function updateSetting($key, $value) {
        $stmt = $this->db->prepare("INSERT INTO {$this->table} (setting_key, setting_value) VALUES (?, ?) ON DUPLICATE KEY UPDATE setting_value = ?");
        return $stmt->execute([$key, $value, $value]);
    }
}
