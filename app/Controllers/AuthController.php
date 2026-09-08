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

        if (!empty($email) && !empty($password)) {
            try {
                $userModel = new \App\Models\User();
                $user = $userModel->findByEmail($email);

                if ($user && password_verify($password, $user['password'])) {
                    $_SESSION['user'] = [
                        'id' => $user['id'],
                        'name' => $user['name'],
                        'email' => $user['email'],
                        'role' => $user['role'] ?? 'admin'
                    ];
                    header('Location: /admin/escritorio');
                    exit;
                }
            } catch (\Exception $e) {
                // Database fallback
            }
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
