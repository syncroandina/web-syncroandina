<?php
namespace Core;

class FileHelper {
    /**
     * Sube un archivo al servidor.
     * 
     * @param array $file El array $_FILES['input_name']
     * @param string $folder Carpeta destino dentro de public/
     * @param array $allowedExtensions Extensiones permitidas
     * @return string|null La ruta relativa del archivo subido o null si falla
     */
    public static function upload($file, $folder = 'assets/uploads/', $allowedExtensions = []) {
        if (!isset($file) || $file['error'] !== UPLOAD_ERR_OK) {
            return null;
        }

        $fileName = $file['name'];
        $fileTmpPath = $file['tmp_name'];
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        if (!empty($allowedExtensions) && !in_array($fileExtension, $allowedExtensions)) {
            return null;
        }

        $uploadDir = __DIR__ . '/../public/' . $folder;
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        // Generar nombre único para evitar colisiones y caché
        $newFileName = bin2hex(random_bytes(8)) . '.' . $fileExtension;
        $destPath = $uploadDir . $newFileName;

        if (move_uploaded_file($fileTmpPath, $destPath)) {
            return '/' . $folder . $newFileName;
        }

        return null;
    }

    /**
     * Elimina un archivo físicamente del servidor.
     * 
     * @param string|null $path Ruta relativa del archivo (ej: /assets/uploads/file.jpg)
     * @return bool True si se eliminó o no existía, false si falló
     */
    public static function delete($path) {
        if (empty($path)) return true;

        // Limpiar el path de parámetros de caché (ej: ?v=123)
        $path = explode('?', $path)[0];
        
        $fullPath = __DIR__ . '/../public' . $path;
        
        if (file_exists($fullPath) && is_file($fullPath)) {
            return unlink($fullPath);
        }

        return true;
    }
}
