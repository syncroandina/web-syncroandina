<?php
$config = require __DIR__ . '/../config/database.php';
try {
    $pdo = new PDO("mysql:host={$config['host']};dbname={$config['dbname']};charset={$config['charset']}", $config['username'], $config['password'], $config['options']);
    
    // 1. Crear tabla product_categories
    $sqlTable = "CREATE TABLE IF NOT EXISTS product_categories (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        slug VARCHAR(255) NOT NULL UNIQUE,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    $pdo->exec($sqlTable);
    echo "[OK] Tabla product_categories creada.\n";
    
    // 2. Agregar columna category_id a la tabla products si no existe
    $stmt = $pdo->query("DESCRIBE products");
    $columns = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    if (!in_array('category_id', $columns)) {
        $sqlAlter = "ALTER TABLE products 
                     ADD COLUMN category_id INT NULL AFTER is_active,
                     ADD CONSTRAINT fk_products_category FOREIGN KEY (category_id) 
                     REFERENCES product_categories(id) ON DELETE SET NULL";
        $pdo->exec($sqlAlter);
        echo "[OK] Columna category_id añadida a la tabla products con clave foránea.\n";
    } else {
        echo "[INFO] La columna category_id ya existe en la tabla products.\n";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
