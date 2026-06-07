<?php
namespace App\Controllers;

use Core\Controller;

class AuthController extends Controller {
    public function login() {
        if(isset($_SESSION['user'])) {
            header('Location: /admin/escritorio');
            exit;
        }
        return $this->view('pages/login', ['title' => 'Portal de Clientes - Syncro Andina']);
    }

    public function authenticate() {
        $email = \Core\Security::sanitizeInput($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $csrf_token = $_POST['csrf_token'] ?? '';

        if (!\Core\Security::verifyCSRFToken($csrf_token)) {
            header('Location: /iniciar-sesion?error=csrf');
            exit;
        }

        // Simulación rápida de Auth para el prototipo (Luego se conecta al User Model)
        if ($email === 'admin@syncroandina.com' && $password === 'admin123') {
            $_SESSION['user'] = [
                'id' => 1,
                'name' => 'Administrador Syncro',
                'role' => 'admin'
            ];
            header('Location: /admin/escritorio');
            exit;
        }

        header('Location: /iniciar-sesion?error=1');
        exit;
    }

    public function logout() {
        session_destroy();
        header('Location: /iniciar-sesion');
        exit;
    }
}
