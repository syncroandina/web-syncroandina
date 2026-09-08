<?php
namespace App\Controllers;

use Core\Controller;
use App\Services\GitHubUpdaterService;

class WebhookController extends Controller {

    public function handleGitHubWebhook() {
        header('Content-Type: application/json');

        $config = GitHubUpdaterService::getSettings();
        $secret = $config['secret'] ?? '';

        $payload = file_get_contents('php://input');
        $signatureHeader = $_SERVER['HTTP_X_HUB_SIGNATURE_256'] ?? '';

        // Si se configuró un Secret en el CMS, validar la firma HMAC SHA256 de GitHub
        if (!empty($secret)) {
            if (empty($signatureHeader)) {
                http_response_code(401);
                echo json_encode(['success' => false, 'message' => 'Falta la firma de autenticación X-Hub-Signature-256']);
                exit;
            }

            $expectedSignature = 'sha256=' . hash_hmac('sha256', $payload, $secret);
            if (!hash_equals($expectedSignature, $signatureHeader)) {
                http_response_code(403);
                echo json_encode(['success' => false, 'message' => 'Firma de Webhook de GitHub inválida. Secret incorrecto.']);
                exit;
            }
        }

        // Ejecutar Proceso de Actualización
        $result = GitHubUpdaterService::performUpdate();

        if ($result['success']) {
            http_response_code(200);
        } else {
            http_response_code(500);
        }

        echo json_encode($result);
        exit;
    }
}
