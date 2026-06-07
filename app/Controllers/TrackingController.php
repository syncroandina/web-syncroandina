<?php
namespace App\Controllers;

use Core\Controller;
use App\Models\Analytics;

class TrackingController extends Controller {
    public function logInteraction() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = json_decode(file_get_contents('php://input'), true);
            $type = $data['type'] ?? null;
            $url = $data['url'] ?? $_SERVER['HTTP_REFERER'] ?? '';
            
            if ($type) {
                $analytics = new Analytics();
                $ip = $_SERVER['REMOTE_ADDR'] ?? '';
                $analytics->logInteraction($type, $url, $ip);
            }
            
            echo json_encode(['success' => true]);
            exit;
        }
    }
}
