<?php
require __DIR__ . '/../vendor/autoload.php';
$settingModel = new \App\Models\Setting();
$all = $settingModel->getAll();
echo "SETTINGS DUMP:\n";
print_r($all);
