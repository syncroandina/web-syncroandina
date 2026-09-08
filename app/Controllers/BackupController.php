<?php
namespace App\Controllers;

use App\Services\SiteBackupService;

class BackupController extends \Core\Controller {

    public function __construct() {
        if (!isset($_SESSION['user'])) {
            header('Location: ' . url('iniciar-sesion'));
            exit;
        }
    }

    public function index() {
        $limits = SiteBackupService::getPHPUploadLimits();
        $uploadsDir = __DIR__ . '/../../public/uploads';
        $uploadsSizeMb = 0;
        $filesCount = 0;

        if (is_dir($uploadsDir)) {
            $iterator = new \RecursiveIteratorIterator(
                new \RecursiveDirectoryIterator($uploadsDir, \RecursiveDirectoryIterator::SKIP_DOTS),
                \RecursiveIteratorIterator::SELF_FIRST
            );
            foreach ($iterator as $file) {
                if ($file->isFile()) {
                    $uploadsSizeMb += $file->getSize();
                    $filesCount++;
                }
            }
        }
        $uploadsSizeMb = round($uploadsSizeMb / 1024 / 1024, 2);

        $this->adminView('backup_site', [
            'title' => 'Exportar e Importar Sitio Web - Panel Admin',
            'limits' => $limits,
            'uploadsSizeMb' => $uploadsSizeMb,
            'filesCount' => $filesCount
        ]);
    }

    public function export() {
        try {
            if (ob_get_length()) ob_clean();
            $zipPath = SiteBackupService::generateBackupZip();
            if (!file_exists($zipPath)) {
                throw new \Exception('No se pudo localizar el archivo comprimido para la descarga.');
            }

            $filename = basename($zipPath);
            header('Content-Type: application/zip');
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            header('Content-Length: ' . filesize($zipPath));
            header('Pragma: no-cache');
            header('Expires: 0');

            readfile($zipPath);
            @unlink($zipPath);
            exit;
        } catch (\Throwable $e) {
            if (ob_get_length()) ob_clean();
            http_response_code(500);
            header('Content-Type: application/json');
            echo json_encode(['error' => $e->getMessage()]);
            exit;
        }
    }

    public function import() {
        if (ob_get_length()) ob_clean();
        ob_start();

        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_FILES['backup_file'])) {
                throw new \Exception('Por favor selecciona un archivo ZIP de respaldo válido.');
            }

            $file = $_FILES['backup_file'];
            if ($file['error'] !== UPLOAD_ERR_OK) {
                throw new \Exception('Error al subir el archivo (Código de error PHP: ' . $file['error'] . ').');
            }

            $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            if ($ext !== 'zip') {
                throw new \Exception('Formato no permitido. Únicamente se aceptan archivos comprimidos .ZIP.');
            }

            $success = SiteBackupService::restoreBackupZip($file['tmp_name']);

            $result = [
                'success' => true,
                'message' => '¡El sitio web ha sido restaurado con éxito! Se han actualizado los datos y archivos multimedia.'
            ];
        } catch (\Throwable $e) {
            $result = [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }

        if (ob_get_length()) ob_end_clean();
        header('Content-Type: application/json');
        echo json_encode($result);
        exit;
    }

    private function adminView($viewName, $data = []) {
        extract($data);
        require __DIR__ . '/../views/admin/layout/header.php';
        require __DIR__ . '/../views/admin/layout/sidebar.php';
        require __DIR__ . '/../views/admin/layout/topbar.php';
        require __DIR__ . "/../views/admin/{$viewName}.php";
        require __DIR__ . '/../views/admin/layout/footer.php';
    }
}
