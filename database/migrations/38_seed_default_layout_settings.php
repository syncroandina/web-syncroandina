<?php
return function($pdo) {
    $stmt = $pdo->prepare("
        INSERT INTO settings (setting_key, setting_value) 
        VALUES ('container_desktop', '85%'), ('container_tablet', '90%'), ('container_mobile', '90%')
        ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value)
    ");
    $stmt->execute();
};
