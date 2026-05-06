<?php
namespace Core;

class Security {
    /**
     * Genera un token CSRF y lo guarda en la sesión
     */
    public static function generateCSRFToken() {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    /**
     * Verifica que el token enviado coincida con el de la sesión
     */
    public static function verifyCSRFToken($token) {
        if (isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token)) {
            return true;
        }
        return false;
    }

    /**
     * Sanitiza inputs de usuario recursivamente para prevenir XSS
     */
    public static function sanitizeInput($data) {
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                $data[$key] = self::sanitizeInput($value);
            }
        } else {
            $data = htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
        }
        return $data;
    }

    /**
     * Sanitiza HTML rico para permitir solo etiquetas de formato seguras
     */
    public static function sanitizeHTML($data) {
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                $data[$key] = self::sanitizeHTML($value);
            }
        } else {
            // Permitir solo etiquetas básicas seguras para texto enriquecido
            $allowed_tags = '<p><br><strong><em><u><s><ul><ol><li><a><h1><h2><h3><h4><h5><h6>';
            $data = strip_tags(trim($data), $allowed_tags);
        }
        return $data;
    }
}
