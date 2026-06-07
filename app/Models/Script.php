<?php
namespace App\Models;

use Core\Model;
use PDO;

class Script extends Model {
    protected $table = 'scripts';

    /**
     * Obtiene los scripts activos.
     * Si es la página de agradecimiento ($isThanksPage = true), incluye scripts con page_restriction = 'thanks_only' y 'all'.
     * Si no, solo incluye los de 'all'.
     */
    public function getActiveForPage($isThanksPage = false) {
        if ($isThanksPage) {
            $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE is_active = 1 ORDER BY id ASC");
            $stmt->execute();
        } else {
            $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE is_active = 1 AND page_restriction = 'all' ORDER BY id ASC");
            $stmt->execute();
        }
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
