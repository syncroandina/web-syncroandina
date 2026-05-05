<?php
namespace App\Controllers;

use Core\Controller;

class AdminController extends Controller {
    public function __construct() {
        if (!isset($_SESSION['user'])) {
            header('Location: /login');
            exit;
        }
    }

    protected function adminView($name, $data = []) {
        extract($data);
        require __DIR__ . '/../views/admin/layout/header.php';
        require __DIR__ . '/../views/admin/layout/sidebar.php';
        require __DIR__ . '/../views/admin/layout/topbar.php';
        require __DIR__ . "/../views/admin/{$name}.php";
        require __DIR__ . '/../views/admin/layout/footer.php';
    }

    public function dashboard() {
        return $this->adminView('dashboard', ['title' => 'Panel de Control']);
    }

    public function projects() {
        return $this->adminView('projects/index', ['title' => 'Gestión de Proyectos']);
    }
}
