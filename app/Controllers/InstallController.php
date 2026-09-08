<?php
namespace App\Controllers;

use Core\Controller;
use PDO;
use PDOException;

class InstallController extends Controller {

    public function isInstalled() {
        $dbConfigPath = __DIR__ . '/../../config/database.php';
        $lockPath = __DIR__ . '/../../storage/installed.lock';
        return file_exists($dbConfigPath) && file_exists($lockPath);
    }

    public function index() {
        if ($this->isInstalled()) {
            header('Location: ' . url('iniciar-sesion'));
            exit;
        }

        $step = isset($_GET['step']) ? (int)$_GET['step'] : 1;
        if ($step < 1 || $step > 4) $step = 1;

        $requirements = $this->checkRequirements();

        $this->view('installer/index', [
            'step' => $step,
            'requirements' => $requirements,
            'title' => 'Asistente de Instalación Web'
        ]);
    }

    public function checkRequirements() {
        $reqs = [
            'php' => [
                'name' => 'Versión de PHP >= 7.4',
                'pass' => version_compare(PHP_VERSION, '7.4.0', '>='),
                'current' => PHP_VERSION
            ],
            'pdo' => [
                'name' => 'Extensión PDO MySQL',
                'pass' => extension_loaded('pdo') && extension_loaded('pdo_mysql'),
                'current' => extension_loaded('pdo_mysql') ? 'Instalado' : 'No instalado'
            ],
            'mbstring' => [
                'name' => 'Extensión Mbstring',
                'pass' => extension_loaded('mbstring'),
                'current' => extension_loaded('mbstring') ? 'Instalado' : 'No instalado'
            ],
            'gd' => [
                'name' => 'Extensión GD (para imágenes)',
                'pass' => extension_loaded('gd'),
                'current' => extension_loaded('gd') ? 'Instalado' : 'No instalado'
            ],
            'fileinfo' => [
                'name' => 'Extensión Fileinfo (Recomendada)',
                'pass' => extension_loaded('fileinfo'),
                'required' => false,
                'current' => extension_loaded('fileinfo') ? 'Instalado' : 'No instalado (opcional)'
            ],
            'config_writable' => [
                'name' => 'Permisos de Escritura en carpeta config/',
                'pass' => is_writable(__DIR__ . '/../../config'),
                'required' => true,
                'current' => is_writable(__DIR__ . '/../../config') ? 'Escribible' : 'Sin permiso'
            ],
            'uploads_writable' => [
                'name' => 'Permisos de Escritura en carpeta public/uploads/',
                'pass' => is_writable(__DIR__ . '/../../public') || (file_exists(__DIR__ . '/../../public/uploads') && is_writable(__DIR__ . '/../../public/uploads')),
                'required' => true,
                'current' => 'Escribible'
            ]
        ];

        $allPass = true;
        foreach ($reqs as $r) {
            $isRequired = $r['required'] ?? true;
            if ($isRequired && !$r['pass']) {
                $allPass = false;
                break;
            }
        }
        $reqs['_all_pass'] = $allPass;

        return $reqs;
    }

    public function testDatabase() {
        header('Content-Type: application/json');

        if ($this->isInstalled()) {
            echo json_encode(['success' => false, 'message' => 'El sitio web ya se encuentra instalado.']);
            exit;
        }

        $host = trim($_POST['host'] ?? '127.0.0.1');
        $port = trim($_POST['port'] ?? '3306');
        $dbname = trim($_POST['dbname'] ?? 'mi_empresa_db');
        $user = trim($_POST['user'] ?? 'root');
        $pass = $_POST['pass'] ?? '';

        if (empty($host) || empty($dbname) || empty($user)) {
            echo json_encode(['success' => false, 'message' => 'Por favor completa todos los campos requeridos de la base de datos.']);
            exit;
        }

        try {
            // Intentar conexión al servidor MySQL sin especificar BD primero
            $pdo = new PDO(
                "mysql:host={$host};port={$port};charset=utf8mb4",
                $user,
                $pass,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_TIMEOUT => 5
                ]
            );

            // Intentar crear BD si no existe
            $pdo->exec("CREATE DATABASE IF NOT EXISTS `{$dbname}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;");
            
            // Conectar ahora a la BD directamente
            $pdo->exec("USE `{$dbname}`;");

            echo json_encode([
                'success' => true,
                'message' => '¡Conexión exitosa a MySQL! Base de datos "' . $dbname . '" lista para la instalación.'
            ]);
        } catch (PDOException $e) {
            echo json_encode([
                'success' => false,
                'message' => 'Error al conectar a MySQL: ' . $e->getMessage()
            ]);
        }
        exit;
    }

    public function processInstallation() {
        header('Content-Type: application/json');

        if ($this->isInstalled()) {
            echo json_encode(['success' => false, 'message' => 'El sitio web ya fue instalado anteriormente.']);
            exit;
        }

        // Datos de Base de Datos
        $host = trim($_POST['host'] ?? '127.0.0.1');
        $port = trim($_POST['port'] ?? '3306');
        $dbname = trim($_POST['dbname'] ?? 'mi_empresa_db');
        $user = trim($_POST['user'] ?? 'root');
        $pass = $_POST['pass'] ?? '';

        // Datos del Administrador & Sitio
        $siteTitle = trim($_POST['site_title'] ?? 'Mi Sitio Web');
        $adminName = trim($_POST['admin_name'] ?? 'Administrador Principal');
        $adminEmail = trim($_POST['admin_email'] ?? 'admin@midominio.com');
        $adminPass = $_POST['admin_password'] ?? '';

        if (empty($adminName) || empty($adminEmail) || empty($adminPass)) {
            echo json_encode(['success' => false, 'message' => 'Por favor completa los datos del Administrador.']);
            exit;
        }

        if (!filter_var($adminEmail, FILTER_VALIDATE_EMAIL)) {
            echo json_encode(['success' => false, 'message' => 'El correo electrónico del administrador no es válido.']);
            exit;
        }

        if (strlen($adminPass) < 6) {
            echo json_encode(['success' => false, 'message' => 'La contraseña debe tener al menos 6 caracteres.']);
            exit;
        }

        try {
            // 1. Conexión PDO a MySQL
            $pdo = new PDO(
                "mysql:host={$host};port={$port};charset=utf8mb4",
                $user,
                $pass,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false
                ]
            );

            // Crear BD si no existe
            $pdo->exec("CREATE DATABASE IF NOT EXISTS `{$dbname}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;");
            $pdo->exec("USE `{$dbname}`;");

            // 2. Crear carpetas de almacenamiento si no existen
            $storageDir = __DIR__ . '/../../storage';
            if (!file_exists($storageDir)) {
                @mkdir($storageDir, 0755, true);
            }

            $uploadsDir = __DIR__ . '/../../public/uploads';
            if (!file_exists($uploadsDir)) {
                @mkdir($uploadsDir, 0755, true);
            }
            $servicesDir = $uploadsDir . '/services';
            if (!file_exists($servicesDir)) {
                @mkdir($servicesDir, 0755, true);
            }

            // 3. Escribir archivo config/database.php
            $configContent = "<?php\nreturn [\n" .
                "    'host' => '" . addslashes($host) . "',\n" .
                "    'port' => " . (int)$port . ",\n" .
                "    'dbname' => '" . addslashes($dbname) . "',\n" .
                "    'username' => '" . addslashes($user) . "',\n" .
                "    'password' => '" . addslashes($pass) . "',\n" .
                "    'charset' => 'utf8mb4',\n" .
                "    'options' => [\n" .
                "        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,\n" .
                "        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,\n" .
                "        PDO::ATTR_EMULATE_PREPARES => false,\n" .
                "    ]\n" .
                "];\n";

            file_put_contents(__DIR__ . '/../../config/database.php', $configContent);

            // 4. Crear tabla de migraciones y ejecutar migraciones en orden
            $pdo->exec("
                CREATE TABLE IF NOT EXISTS migrations (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    migration VARCHAR(255) NOT NULL,
                    executed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
            ");

            $migrationFiles = glob(__DIR__ . '/../../database/migrations/*.php');
            sort($migrationFiles);

            foreach ($migrationFiles as $file) {
                $filename = basename($file);
                $stmtCheck = $pdo->prepare("SELECT COUNT(*) FROM migrations WHERE migration = ?");
                $stmtCheck->execute([$filename]);
                if ($stmtCheck->fetchColumn() == 0) {
                    $sql = require $file;
                    if (is_callable($sql)) {
                        $sql($pdo);
                    } else if (is_string($sql) && !empty(trim($sql))) {
                        $pdo->exec($sql);
                    }
                    $stmtIns = $pdo->prepare("INSERT INTO migrations (migration) VALUES (?)");
                    $stmtIns->execute([$filename]);
                }
            }

            // 5. Insertar/Actualizar Super Administrador
            $hashedPassword = password_hash($adminPass, PASSWORD_BCRYPT);
            
            // Verificar si la tabla de usuarios ya contiene a este admin o está vacía
            $stmtUser = $pdo->prepare("SELECT id FROM users WHERE email = ?");
            $stmtUser->execute([$adminEmail]);
            $userRow = $stmtUser->fetch();

            if ($userRow) {
                $stmtUp = $pdo->prepare("UPDATE users SET name = ?, password = ?, role = 'admin' WHERE id = ?");
                $stmtUp->execute([$adminName, $hashedPassword, $userRow['id']]);
            } else {
                $stmtIn = $pdo->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, 'admin')");
                $stmtIn->execute([$adminName, $adminEmail, $hashedPassword]);
            }

            // 6. Guardar Título del Sitio en settings
            $stmtSet = $pdo->prepare("
                INSERT INTO settings (setting_key, setting_value) 
                VALUES ('services_title', ?), ('services_locations_title', 'Área de Cobertura y Lugares')
                ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value)
            ");
            $stmtSet->execute([$siteTitle]);

            // 7. Crear candado de instalación y archivo de versión inicial
            $lockContent = json_encode([
                'installed_at' => date('Y-m-d H:i:s'),
                'version' => '1.0.0',
                'admin_email' => $adminEmail
            ], JSON_PRETTY_PRINT);
            file_put_contents($storageDir . '/installed.lock', $lockContent);

            $versionContent = json_encode([
                'version' => '1.0.0',
                'commit_hash' => 'initial',
                'updated_at' => date('Y-m-d H:i:s')
            ], JSON_PRETTY_PRINT);
            file_put_contents($storageDir . '/version.json', $versionContent);

            echo json_encode([
                'success' => true,
                'message' => '¡Instalación completada con éxito!',
                'redirect' => url('install?step=4')
            ]);

        } catch (PDOException $e) {
            echo json_encode([
                'success' => false,
                'message' => 'Error durante la ejecución del instalador: ' . $e->getMessage()
            ]);
        } catch (\Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => 'Error al guardar archivos de configuración: ' . $e->getMessage()
            ]);
        }
        exit;
    }
}
