<?php
namespace Core;

use PDO;
use PDOException;

class Model {
    protected $db;
    protected $table;

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
            die("Error de conexión a la base de datos: " . $e->getMessage());
        }
    }

    public function find($id) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function all($order = null) {
        $sql = "SELECT * FROM {$this->table}";
        if ($order) $sql .= " ORDER BY $order";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function where($column, $value, $operator = '=', $order = null) {
        $sql = "SELECT * FROM {$this->table} WHERE $column $operator ?";
        if ($order) $sql .= " ORDER BY $order";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$value]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function save($data) {
        if (isset($data['id']) && !empty($data['id'])) {
            $id = $data['id'];
            unset($data['id']);
            $fields = [];
            foreach (array_keys($data) as $key) {
                $fields[] = "$key = ?";
            }
            $sql = "UPDATE {$this->table} SET " . implode(', ', $fields) . " WHERE id = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute(array_merge(array_values($data), [$id]));
            return $id;
        } else {
            $columns = implode(', ', array_keys($data));
            $placeholders = implode(', ', array_fill(0, count($data), '?'));
            $sql = "INSERT INTO {$this->table} ($columns) VALUES ($placeholders)";
            $stmt = $this->db->prepare($sql);
            $stmt->execute(array_values($data));
            return $this->db->lastInsertId();
        }
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
