<?php
namespace Core;

use PDO;
use PDOException;

class Model {
    protected $db;

    public function __construct() {
        $config = require __DIR__ . '/../config/database.php';
        
        try {
            $this->db = new PDO(
                "mysql:host={$config['host']};dbname={$config['dbname']};charset={$config['charset']}",
                $config['username'],
                $config['password'],
                $config['options']
            );
        } catch (PDOException $e) {
            // Log the error securely in a real app
            die("Error de conexión a la base de datos. Por favor, revisa la configuración. Detalle: " . $e->getMessage());
        }
    }
}
