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
        $projectModel = new \App\Models\Project();
        $settingModel = new \App\Models\Setting();
        $galleryModel = new \App\Models\ProjectGallery();
        $projects = $projectModel->getAllActive();
        $settings = $settingModel->getAll();

        foreach ($projects as &$project) {
            $project['gallery'] = $galleryModel->getByProject($project['id']);
        }

        return $this->adminView('projects/index', [
            'title' => 'Gestión de Proyectos',
            'projects' => $projects,
            'settings' => $settings
        ]);
    }

    public function saveProjectSettings() {
        if (!\Core\Security::verifyCSRFToken($_POST['csrf_token'] ?? '')) {
            die('Invalid CSRF token');
        }

        $settingModel = new \App\Models\Setting();
        $keys = ['projects_home_title', 'projects_home_subtitle', 'projects_page_title', 'projects_page_subtitle'];

        foreach ($keys as $key) {
            $value = \Core\Security::sanitizeInput($_POST[$key] ?? '');
            $settingModel->updateSetting($key, $value);
        }

        header('Location: /admin/proyectos?success=settings_saved');
        exit;
    }

    public function services() {
        $serviceModel = new \App\Models\Service();
        $settingModel = new \App\Models\Setting();
        $services = $serviceModel->all('sort_order ASC, id ASC');
        $settings = $settingModel->getAll();
        
        return $this->adminView('services/index', [
            'title' => 'Gestión de Servicios',
            'services' => $services,
            'settings' => $settings
        ]);
    }

    public function saveServiceSettings() {
        if (!\Core\Security::verifyCSRFToken($_POST['csrf_token'] ?? '')) {
            die('Invalid CSRF token');
        }

        $settingModel = new \App\Models\Setting();
        $keys = ['services_label', 'services_title', 'services_description', 'services_limit', 'page_services_title', 'page_services_description'];

        foreach ($keys as $key) {
            $value = \Core\Security::sanitizeInput($_POST[$key] ?? '');
            $settingModel->updateSetting($key, $value);
        }

        header('Location: /admin/servicios?success=settings_saved');
        exit;
    }

    public function getService() {
        $id = $_GET['id'] ?? null;
        if (!$id) return json_encode(['success' => false]);
        
        $serviceModel = new \App\Models\Service();
        $service = $serviceModel->getFullDetails($id);
        
        header('Content-Type: application/json');
        echo json_encode($service);
        exit;
    }

    public function saveService() {
        if (!\Core\Security::verifyCSRFToken($_POST['csrf_token'] ?? '')) {
            die('Invalid CSRF token');
        }

        $id = $_POST['id'] ?? null;
        $serviceModel = new \App\Models\Service();
        $oldService = $id ? $serviceModel->find($id) : null;

        $data = [
            'title' => \Core\Security::sanitizeInput($_POST['title'] ?? ''),
            'slug' => \Core\Security::sanitizeInput($_POST['slug'] ?? ''),
            'content' => \Core\Security::sanitizeHTML($_POST['content'] ?? ''),
            'is_active' => isset($_POST['is_active']) ? 1 : 0,
            'heading_description' => \Core\Security::sanitizeInput($_POST['heading_description'] ?? ''),
            'heading_details' => \Core\Security::sanitizeInput($_POST['heading_details'] ?? ''),
            'heading_gallery' => \Core\Security::sanitizeInput($_POST['heading_gallery'] ?? ''),
            'heading_cta' => \Core\Security::sanitizeInput($_POST['heading_cta'] ?? ''),
            'cta_description' => \Core\Security::sanitizeInput($_POST['cta_description'] ?? '')
        ];

        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $newPath = \Core\FileHelper::upload($_FILES['image'], 'assets/images/services/', ['webp', 'jpg', 'jpeg', 'png']);
            if ($newPath) {
                if ($oldService && !empty($oldService['image'])) {
                    \Core\FileHelper::delete($oldService['image']);
                }
                $data['image'] = $newPath;
            }
        }

        if ($id) $data['id'] = $id;
        $serviceId = $serviceModel->save($data);
        if (!$serviceId) $serviceId = $id;

        // Guardar Items
        $itemModel = new \App\Models\ServiceItem();
        $itemModel->deleteByService($serviceId);
        if (isset($_POST['items_titles'])) {
            foreach ($_POST['items_titles'] as $index => $title) {
                if (!empty($title)) {
                    $itemModel->save([
                        'service_id' => $serviceId,
                        'title' => \Core\Security::sanitizeInput($title),
                        'description' => \Core\Security::sanitizeInput($_POST['items_descriptions'][$index] ?? ''),
                        'sort_order' => $index
                    ]);
                }
            }
        }

        // Guardar Galería (Imágenes nuevas)
        $galleryModel = new \App\Models\ServiceGallery();
        if (isset($_FILES['gallery_images'])) {
            $files = $_FILES['gallery_images'];
            for ($i = 0; $i < count($files['name']); $i++) {
                if ($files['error'][$i] === UPLOAD_ERR_OK) {
                    $file = [
                        'name' => $files['name'][$i],
                        'type' => $files['type'][$i],
                        'tmp_name' => $files['tmp_name'][$i],
                        'error' => $files['error'][$i],
                        'size' => $files['size'][$i]
                    ];
                    $path = \Core\FileHelper::upload($file, 'assets/images/services/gallery/', ['webp', 'jpg', 'jpeg', 'png']);
                    if ($path) {
                        $galleryModel->save([
                            'service_id' => $serviceId,
                            'image_path' => $path,
                            'sort_order' => 99 // Se puede ajustar después
                        ]);
                    }
                }
            }
        }

        header('Location: /admin/servicios?success=service_saved');
        exit;
    }

    public function deleteService() {
        if (!\Core\Security::verifyCSRFToken($_POST['csrf_token'] ?? '')) {
            die('Invalid CSRF token');
        }

        $id = $_POST['id'] ?? null;
        if ($id) {
            $serviceModel = new \App\Models\Service();
            $service = $serviceModel->find($id);
            if ($service) {
                if (!empty($service['image'])) {
                    \Core\FileHelper::delete($service['image']);
                }
                $serviceModel->delete($id);
            }
        }

        header('Location: /admin/servicios?success=service_deleted');
        exit;
    }

    public function duplicateService() {
        if (!\Core\Security::verifyCSRFToken($_POST['csrf_token'] ?? '')) {
            die('Invalid CSRF token');
        }

        $id = $_POST['id'] ?? null;
        if ($id) {
            $serviceModel = new \App\Models\Service();
            $service = $serviceModel->getFullDetails($id);
            if ($service) {
                // 1. Duplicar la imagen principal en el disco
                $newImagePath = null;
                if (!empty($service['image'])) {
                    $cleanPath = explode('?', $service['image'])[0];
                    $sourceFile = __DIR__ . '/../public' . $cleanPath;
                    if (file_exists($sourceFile) && is_file($sourceFile)) {
                        $extension = strtolower(pathinfo($cleanPath, PATHINFO_EXTENSION));
                        $folder = 'assets/images/services/';
                        $uploadDir = __DIR__ . '/../public/' . $folder;
                        if (!is_dir($uploadDir)) {
                            mkdir($uploadDir, 0755, true);
                        }
                        $newFileName = bin2hex(random_bytes(8)) . '.' . $extension;
                        $destFile = $uploadDir . $newFileName;
                        if (copy($sourceFile, $destFile)) {
                            $newImagePath = '/' . $folder . $newFileName;
                        }
                    }
                }

                $newSlug = $service['slug'] . '-copia-' . bin2hex(random_bytes(2));

                $serviceData = [
                    'title' => $service['title'] . ' (Copia)',
                    'slug' => $newSlug,
                    'content' => $service['content'],
                    'image' => $newImagePath ?: $service['image'],
                    'is_active' => 0,
                    'heading_description' => $service['heading_description'] ?? null,
                    'heading_details' => $service['heading_details'] ?? null,
                    'heading_gallery' => $service['heading_gallery'] ?? null,
                    'heading_cta' => $service['heading_cta'] ?? null,
                    'cta_description' => $service['cta_description'] ?? null
                ];

                $newServiceId = $serviceModel->save($serviceData);

                if ($newServiceId) {
                    // 2. Duplicar los ítems de detalle
                    if (!empty($service['items'])) {
                        $itemModel = new \App\Models\ServiceItem();
                        foreach ($service['items'] as $item) {
                            $itemModel->save([
                                'service_id' => $newServiceId,
                                'title' => $item['title'],
                                'description' => $item['description'],
                                'sort_order' => $item['sort_order']
                            ]);
                        }
                    }

                    // 3. Duplicar las imágenes físicas y registros de la galería
                    if (!empty($service['gallery'])) {
                        $galleryModel = new \App\Models\ServiceGallery();
                        foreach ($service['gallery'] as $galleryItem) {
                            $newGalleryPath = null;
                            if (!empty($galleryItem['image_path'])) {
                                $cleanGalPath = explode('?', $galleryItem['image_path'])[0];
                                $sourceGalFile = __DIR__ . '/../public' . $cleanGalPath;
                                if (file_exists($sourceGalFile) && is_file($sourceGalFile)) {
                                    $extension = strtolower(pathinfo($cleanGalPath, PATHINFO_EXTENSION));
                                    $folder = 'assets/images/services/gallery/';
                                    $uploadDir = __DIR__ . '/../public/' . $folder;
                                    if (!is_dir($uploadDir)) {
                                        mkdir($uploadDir, 0755, true);
                                    }
                                    $newFileName = bin2hex(random_bytes(8)) . '.' . $extension;
                                    $destFile = $uploadDir . $newFileName;
                                    if (copy($sourceGalFile, $destFile)) {
                                        $newGalleryPath = '/' . $folder . $newFileName;
                                    }
                                }
                            }

                            $galleryModel->save([
                                'service_id' => $newServiceId,
                                'image_path' => $newGalleryPath ?: $galleryItem['image_path'],
                                'sort_order' => $galleryItem['sort_order']
                            ]);
                        }
                    }
                }
            }
        }

        header('Location: /admin/servicios?success=service_duplicated');
        exit;
    }

    public function toggleServiceStatus() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = json_decode(file_get_contents('php://input'), true);
            $id = $data['id'] ?? null;
            $status = $data['status'] ?? 0;

            if ($id) {
                $serviceModel = new \App\Models\Service();
                $serviceModel->save(['id' => $id, 'is_active' => $status]);
                echo json_encode(['success' => true]);
                exit;
            }
        }
        http_response_code(400);
        echo json_encode(['success' => false]);
        exit;
    }

    public function reorderServices() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = json_decode(file_get_contents('php://input'), true);
            if(isset($data['order']) && is_array($data['order'])) {
                $serviceModel = new \App\Models\Service();
                foreach($data['order'] as $index => $id) {
                    $serviceModel->save(['id' => $id, 'sort_order' => $index + 1]);
                }
                echo json_encode(['success' => true]);
                exit;
            }
        }
        http_response_code(400);
        echo json_encode(['success' => false]);
        exit;
    }

    public function deleteGalleryImage() {
        if (!\Core\Security::verifyCSRFToken($_POST['csrf_token'] ?? '')) {
            die('Invalid CSRF token');
        }

        $id = $_POST['id'] ?? null;
        if ($id) {
            $galleryModel = new \App\Models\ServiceGallery();
            $image = $galleryModel->find($id);
            if ($image) {
                \Core\FileHelper::delete($image['image_path']);
                $galleryModel->delete($id);
            }
        }

        echo json_encode(['success' => true]);
        exit;
    }

    public function sliders() {
        $sliderModel = new \App\Models\Slider();
        $settingModel = new \App\Models\Setting();
        $sliders = $sliderModel->getAll();
        $settings = $settingModel->getAll();
        return $this->adminView('sliders/index', [
            'title' => 'Gestión de Sliders',
            'sliders' => $sliders,
            'settings' => $settings
        ]);
    }

    public function saveSlider() {
        if (!\Core\Security::verifyCSRFToken($_POST['csrf_token'] ?? '')) {
            die('Invalid CSRF token');
        }

        $id = $_POST['id'] ?? null;
        $sliderModel = new \App\Models\Slider();
        $oldSlider = $id ? $sliderModel->find($id) : null;
        
        $data = [
            'title' => \Core\Security::sanitizeInput($_POST['title'] ?? ''),
            'top_label' => \Core\Security::sanitizeInput($_POST['top_label'] ?? ''),
            'subtitle' => \Core\Security::sanitizeInput($_POST['subtitle'] ?? ''),
            'button_text' => \Core\Security::sanitizeInput($_POST['button_text'] ?? ''),
            'button_link' => \Core\Security::sanitizeInput($_POST['button_link'] ?? ''),
            'order_index' => (int)($_POST['order_index'] ?? 0),
            'is_active' => isset($_POST['is_active']) ? 1 : 0
        ];

        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $newPath = \Core\FileHelper::upload($_FILES['image'], 'assets/images/sliders/', ['webp', 'jpg', 'jpeg', 'png']);
            if ($newPath) {
                if ($oldSlider) {
                    \Core\FileHelper::delete($oldSlider['image_path']);
                }
                $data['image_path'] = $newPath;
            }
        }

        if ($id) $data['id'] = $id;
        $sliderModel->save($data);

        header('Location: /admin/sliders?success=slider_saved');
        exit;
    }

    public function deleteSlider() {
        if (!\Core\Security::verifyCSRFToken($_POST['csrf_token'] ?? '')) {
            die('Invalid CSRF token');
        }

        $id = $_POST['id'] ?? null;
        if ($id) {
            $sliderModel = new \App\Models\Slider();
            $slider = $sliderModel->find($id);
            if ($slider) {
                \Core\FileHelper::delete($slider['image_path']);
                $sliderModel->delete($id);
            }
        }

        header('Location: /admin/sliders?success=slider_deleted');
        exit;
    }

    public function duplicateSlider() {
        if (!\Core\Security::verifyCSRFToken($_POST['csrf_token'] ?? '')) {
            die('Invalid CSRF token');
        }

        $id = $_POST['id'] ?? null;
        if ($id) {
            $sliderModel = new \App\Models\Slider();
            $slider = $sliderModel->find($id);
            if ($slider) {
                $newImagePath = null;
                if (!empty($slider['image_path'])) {
                    $cleanPath = explode('?', $slider['image_path'])[0];
                    $sourceFile = __DIR__ . '/../../public' . $cleanPath;
                    if (file_exists($sourceFile) && is_file($sourceFile)) {
                        $extension = strtolower(pathinfo($cleanPath, PATHINFO_EXTENSION));
                        $folder = 'assets/images/sliders/';
                        $uploadDir = __DIR__ . '/../../public/' . $folder;
                        if (!is_dir($uploadDir)) {
                            mkdir($uploadDir, 0755, true);
                        }
                        $newFileName = bin2hex(random_bytes(8)) . '.' . $extension;
                        $destFile = $uploadDir . $newFileName;
                        if (copy($sourceFile, $destFile)) {
                            $newImagePath = '/' . $folder . $newFileName;
                        }
                    }
                }

                $data = [
                    'title' => $slider['title'] . ' (Copia)',
                    'top_label' => $slider['top_label'],
                    'subtitle' => $slider['subtitle'],
                    'button_text' => $slider['button_text'],
                    'button_link' => $slider['button_link'],
                    'image_path' => $newImagePath ?: $slider['image_path'],
                    'order_index' => (int)$slider['order_index'] + 1,
                    'is_active' => 0
                ];

                $sliderModel->save($data);
            }
        }

        header('Location: /admin/sliders?success=slider_duplicated');
        exit;
    }

    public function toggleSliderStatus() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = json_decode(file_get_contents('php://input'), true);
            $id = $data['id'] ?? null;
            $status = $data['status'] ?? 0;

            if ($id) {
                $sliderModel = new \App\Models\Slider();
                $sliderModel->save(['id' => $id, 'is_active' => $status]);
                echo json_encode(['success' => true]);
                exit;
            }
        }
        http_response_code(400);
        echo json_encode(['success' => false]);
        exit;
    }

    public function reorderSliders() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = json_decode(file_get_contents('php://input'), true);
            if(isset($data['order']) && is_array($data['order'])) {
                $sliderModel = new \App\Models\Slider();
                foreach($data['order'] as $index => $id) {
                    $sliderModel->save(['id' => $id, 'order_index' => $index + 1]);
                }
                echo json_encode(['success' => true]);
                exit;
            }
        }
        http_response_code(400);
        echo json_encode(['success' => false]);
        exit;
    }

    public function saveProject() {
        if (!\Core\Security::verifyCSRFToken($_POST['csrf_token'] ?? '')) {
            die('Invalid CSRF token');
        }

        $id = $_POST['id'] ?? null;
        $projectModel = new \App\Models\Project();
        $oldProject = $id ? $projectModel->find($id) : null;

        $data = [
            'title' => \Core\Security::sanitizeInput($_POST['title'] ?? ''),
            'slug' => \Core\Security::sanitizeInput($_POST['slug'] ?? ''),
            'description' => \Core\Security::sanitizeInput($_POST['description'] ?? ''),
            'client' => \Core\Security::sanitizeInput($_POST['client'] ?? ''),
            'completion_date' => !empty($_POST['completion_date']) ? \Core\Security::sanitizeInput($_POST['completion_date']) : null,
            'is_active' => isset($_POST['is_active']) ? 1 : 0,
            'challenge_title' => \Core\Security::sanitizeInput($_POST['challenge_title'] ?? 'El Reto'),
            'challenge_desc' => \Core\Security::sanitizeInput($_POST['challenge_desc'] ?? ''),
            'solution_title' => \Core\Security::sanitizeInput($_POST['solution_title'] ?? 'La Solución'),
            'solution_desc' => \Core\Security::sanitizeInput($_POST['solution_desc'] ?? ''),
            'impact_label' => \Core\Security::sanitizeInput($_POST['impact_label'] ?? 'Impacto Logrado'),
            'impact_value' => \Core\Security::sanitizeInput($_POST['impact_value'] ?? '100% Optimizado')
        ];

        if (isset($_FILES['main_image']) && $_FILES['main_image']['error'] === UPLOAD_ERR_OK) {
            $newPath = \Core\FileHelper::upload($_FILES['main_image'], 'assets/images/projects/', ['webp', 'jpg', 'jpeg', 'png']);
            if ($newPath) {
                if ($oldProject) {
                    \Core\FileHelper::delete($oldProject['main_image']);
                }
                $data['main_image'] = $newPath;
            }
        }

        if ($id) $data['id'] = $id;
        $projectId = $projectModel->save($data);

        // Guardar Galería (Imágenes nuevas)
        $projectGalleryModel = new \App\Models\ProjectGallery();
        if (isset($_FILES['project_gallery_images'])) {
            $files = $_FILES['project_gallery_images'];
            for ($i = 0; $i < count($files['name']); $i++) {
                if ($files['error'][$i] === UPLOAD_ERR_OK) {
                    $file = [
                        'name' => $files['name'][$i],
                        'type' => $files['type'][$i],
                        'tmp_name' => $files['tmp_name'][$i],
                        'error' => $files['error'][$i],
                        'size' => $files['size'][$i]
                    ];
                    $path = \Core\FileHelper::upload($file, 'assets/images/projects/gallery/', ['webp', 'jpg', 'jpeg', 'png']);
                    if ($path) {
                        $projectGalleryModel->save([
                            'project_id' => $projectId ?: $id,
                            'image_path' => $path,
                            'order_index' => 99
                        ]);
                    }
                }
            }
        }

        header('Location: /admin/proyectos?success=project_saved');
        exit;
    }

    public function deleteProject() {
        if (!\Core\Security::verifyCSRFToken($_POST['csrf_token'] ?? '')) {
            die('Invalid CSRF token');
        }

        $id = $_POST['id'] ?? null;
        if ($id) {
            $projectModel = new \App\Models\Project();
            $project = $projectModel->find($id);
            if ($project) {
                // Eliminar archivo físico según política
                \Core\FileHelper::delete($project['main_image']);
                $projectModel->delete($id);
            }
        }

        header('Location: /admin/proyectos?success=project_deleted');
        exit;
    }

    public function deleteProjectGalleryImage() {
        if (!\Core\Security::verifyCSRFToken($_POST['csrf_token'] ?? '')) {
            die('Invalid CSRF token');
        }

        $id = $_POST['id'] ?? null;
        if ($id) {
            $galleryModel = new \App\Models\ProjectGallery();
            $image = $galleryModel->find($id);
            if ($image) {
                \Core\FileHelper::delete($image['image_path']);
                $galleryModel->delete($id);
                echo json_encode(['success' => true]);
                exit;
            }
        }
        http_response_code(400);
        echo json_encode(['success' => false]);
        exit;
    }

    public function duplicateProject() {
        if (!\Core\Security::verifyCSRFToken($_POST['csrf_token'] ?? '')) {
            die('Invalid CSRF token');
        }

        $id = $_POST['id'] ?? null;
        if ($id) {
            $projectModel = new \App\Models\Project();
            $project = $projectModel->find($id);
            if ($project) {
                $newImagePath = null;
                if (!empty($project['main_image'])) {
                    $cleanPath = explode('?', $project['main_image'])[0];
                    $sourceFile = __DIR__ . '/../../public/' . $cleanPath;
                    if (file_exists($sourceFile) && is_file($sourceFile)) {
                        $extension = strtolower(pathinfo($cleanPath, PATHINFO_EXTENSION));
                        $folder = 'assets/images/projects/';
                        $uploadDir = __DIR__ . '/../../public/' . $folder;
                        if (!is_dir($uploadDir)) {
                            mkdir($uploadDir, 0755, true);
                        }
                        $newFileName = bin2hex(random_bytes(8)) . '.' . $extension;
                        $destFile = $uploadDir . $newFileName;
                        if (copy($sourceFile, $destFile)) {
                            $newImagePath = $folder . $newFileName;
                        }
                    }
                }

                $randomSuffix = bin2hex(random_bytes(3));
                $data = [
                    'title' => $project['title'] . ' (Copia)',
                    'slug' => $project['slug'] . '-copia-' . $randomSuffix,
                    'description' => $project['description'],
                    'client' => $project['client'],
                    'completion_date' => $project['completion_date'],
                    'main_image' => $newImagePath ?: $project['main_image'],
                    'is_active' => 0
                ];

                $projectModel->save($data);
            }
        }

        header('Location: /admin/proyectos?success=project_duplicated');
        exit;
    }

    public function headerConfig() {
        $settingModel = new \App\Models\Setting();
        $menuLinkModel = new \App\Models\MenuLink();
        
        $settings = $settingModel->getAll();
        $menuLinks = $menuLinkModel->getActive();
        $topLevelLinks = $menuLinkModel->getTopLevel();
        
        return $this->adminView('header_config', [
            'title' => 'Configuración de Header y Menú',
            'settings' => $settings,
            'menuLinks' => $menuLinks,
            'topLevelLinks' => $topLevelLinks
        ]);
    }

    public function identityConfig() {
        $settingModel = new \App\Models\Setting();
        $settings = $settingModel->getAll();
        
        return $this->adminView('identity', [
            'title' => 'Identidad Corporativa',
            'settings' => $settings
        ]);
    }

    public function saveIdentityImages() {
        if (!\Core\Security::verifyCSRFToken($_POST['csrf_token'] ?? '')) {
            die('Invalid CSRF token');
        }

        $settingModel = new \App\Models\Setting();
        $updated = false;
        $error = null;

        // Procesar Logo
        if (isset($_FILES['logo']) && $_FILES['logo']['error'] === UPLOAD_ERR_OK) {
            $oldLogo = $settingModel->get('logo_url');
            $newPath = \Core\FileHelper::upload($_FILES['logo'], 'assets/images/branding/', ['webp', 'png', 'jpg', 'jpeg']);
            if ($newPath) {
                \Core\FileHelper::delete($oldLogo);
                $settingModel->updateSetting('logo_url', $newPath . '?' . time());
                $updated = true;
            } else {
                $error = 'invalid_logo_format';
            }
        }

        // Procesar Favicon
        if (isset($_FILES['favicon']) && $_FILES['favicon']['error'] === UPLOAD_ERR_OK) {
            $oldFavicon = $settingModel->get('favicon_url');
            $newPath = \Core\FileHelper::upload($_FILES['favicon'], 'assets/images/branding/', ['png', 'ico', 'webp']);
            if ($newPath) {
                \Core\FileHelper::delete($oldFavicon);
                $settingModel->updateSetting('favicon_url', $newPath . '?' . time());
                $updated = true;
            } else {
                $error = 'invalid_favicon_format';
            }
        }

        if ($error) {
            header('Location: /admin/identidad?error=' . $error);
        } elseif ($updated) {
            header('Location: /admin/identidad?success=images_saved');
        } else {
            header('Location: /admin/identidad?info=no_changes');
        }
        exit;
    }

    public function deleteIdentityImage() {
        if (!\Core\Security::verifyCSRFToken($_POST['csrf_token'] ?? '')) {
            die('Invalid CSRF token');
        }

        $type = $_POST['type'] ?? ''; // 'logo' o 'favicon'
        $settingModel = new \App\Models\Setting();
        $key = ($type === 'logo') ? 'logo_url' : 'favicon_url';
        
        $currentPath = $settingModel->get($key);
        if ($currentPath) {
            \Core\FileHelper::delete($currentPath);
            $settingModel->updateSetting($key, '');
            header('Location: /admin/identidad?success=image_deleted');
        } else {
            header('Location: /admin/identidad?error=not_found');
        }
        exit;
    }

    public function saveColors() {
        if (!\Core\Security::verifyCSRFToken($_POST['csrf_token'] ?? '')) {
            die('Invalid CSRF token');
        }

        $colors = [
            'color_primary', 'color_secondary', 'color_accent',
            'color_light_gray', 'color_gray', 'color_dark_gray'
        ];

        $settingModel = new \App\Models\Setting();
        foreach ($colors as $color) {
            $value = \Core\Security::sanitizeInput($_POST[$color] ?? '');
            if (!empty($value)) {
                $settingModel->updateSetting($color, $value);
            }
        }

        $this->generateDynamicCSS();

        header('Location: /admin/identidad?success=colors_saved');
        exit;
    }

    public function saveTypography() {
        if (!\Core\Security::verifyCSRFToken($_POST['csrf_token'] ?? '')) {
            die('Invalid CSRF token');
        }

        $fonts = [
            'font_h1', 'font_h2', 'font_h3', 'font_h4', 'font_h5', 'font_h6', 'font_body'
        ];

        $settingModel = new \App\Models\Setting();
        foreach ($fonts as $font) {
            $value = \Core\Security::sanitizeInput($_POST[$font] ?? '');
            if (!empty($value)) {
                $settingModel->updateSetting($font, $value);
            }
        }

        $this->generateDynamicCSS();

        header('Location: /admin/identidad?success=typography_saved');
        exit;
    }

    private function generateDynamicCSS() {
        $settingModel = new \App\Models\Setting();
        $s = $settingModel->getAll();

        $css = ":root {\n";
        $css .= "    --color-primary: " . ($s['color_primary'] ?? '#0f172a') . ";\n";
        $css .= "    --color-secondary: " . ($s['color_secondary'] ?? '#3b82f6') . ";\n";
        $css .= "    --color-accent: " . ($s['color_accent'] ?? '#0ea5e9') . ";\n";
        $css .= "    --color-light-gray: " . ($s['color_light_gray'] ?? '#f8fafc') . ";\n";
        $css .= "    --color-gray: " . ($s['color_gray'] ?? '#64748b') . ";\n";
        $css .= "    --color-dark-gray: " . ($s['color_dark_gray'] ?? '#1e293b') . ";\n";
        
        $css .= "    --font-h1: '" . ($s['font_h1'] ?? 'Inter') . "', sans-serif;\n";
        $css .= "    --font-h2: '" . ($s['font_h2'] ?? 'Inter') . "', sans-serif;\n";
        $css .= "    --font-h3: '" . ($s['font_h3'] ?? 'Inter') . "', sans-serif;\n";
        $css .= "    --font-h4: '" . ($s['font_h4'] ?? 'Inter') . "', sans-serif;\n";
        $css .= "    --font-h5: '" . ($s['font_h5'] ?? 'Inter') . "', sans-serif;\n";
        $css .= "    --font-h6: '" . ($s['font_h6'] ?? 'Inter') . "', sans-serif;\n";
        $css .= "    --font-body: '" . ($s['font_body'] ?? 'Inter') . "', sans-serif;\n";
        $css .= "}\n\n";

        $css .= "body { font-family: var(--font-body); background-color: var(--color-light-gray); color: var(--color-dark-gray); }\n";
        $css .= "h1 { font-family: var(--font-h1); }\n";
        $css .= "h2 { font-family: var(--font-h2); }\n";
        $css .= "h3 { font-family: var(--font-h3); }\n";
        $css .= "h4 { font-family: var(--font-h4); }\n";
        $css .= "h5 { font-family: var(--font-h5); }\n";
        $css .= "h6 { font-family: var(--font-h6); }\n";

        $cssPath = __DIR__ . '/../../public/assets/css/theme.css';
        file_put_contents($cssPath, $css);
    }

    public function savePhone() {
        if (!\Core\Security::verifyCSRFToken($_POST['csrf_token'] ?? '')) {
            die('Invalid CSRF token');
        }
        $phone = \Core\Security::sanitizeInput($_POST['contact_phone'] ?? '');
        $settingModel = new \App\Models\Setting();
        $settingModel->updateSetting('contact_phone', $phone);

        header('Location: /admin/cabecera?success=phone_saved');
        exit;
    }

    public function saveMenuLink() {
        if (!\Core\Security::verifyCSRFToken($_POST['csrf_token'] ?? '')) {
            die('Invalid CSRF token');
        }
        
        $id = $_POST['id'] ?? null;
        $title = \Core\Security::sanitizeInput($_POST['title'] ?? '');
        $url = \Core\Security::sanitizeInput($_POST['url'] ?? '');
        $parent_id = !empty($_POST['parent_id']) ? $_POST['parent_id'] : null;
        $order = (int)($_POST['order_index'] ?? 999);
        
        $menuLinkModel = new \App\Models\MenuLink();
        $menuLinkModel->saveLink($id, $title, $url, $order, $parent_id);

        header('Location: /admin/cabecera?success=link_saved');
        exit;
    }
    
    public function deleteMenuLink() {
        if (!\Core\Security::verifyCSRFToken($_POST['csrf_token'] ?? '')) {
            die('Invalid CSRF token');
        }
        
        $id = $_POST['id'] ?? null;
        if($id) {
            $menuLinkModel = new \App\Models\MenuLink();
            $menuLinkModel->deleteLink($id);
        }
        
        header('Location: /admin/cabecera?success=link_deleted');
        exit;
    }

    public function reorderMenuLinks() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = json_decode(file_get_contents('php://input'), true);
            if(isset($data['order']) && is_array($data['order'])) {
                $menuLinkModel = new \App\Models\MenuLink();
                foreach($data['order'] as $index => $id) {
                    $menuLinkModel->updateOrder($id, $index + 1);
                }
                echo json_encode(['success' => true]);
                exit;
            }
        }
        http_response_code(400);
        echo json_encode(['success' => false]);
        exit;
    }

    public function aboutConfig() {
        $settingModel = new \App\Models\Setting();
        $settings = $settingModel->getAll();
        
        return $this->adminView('about_config', [
            'title' => 'Configuración de Página Nosotros',
            'settings' => $settings
        ]);
    }

    public function saveAboutConfig() {
        if (!\Core\Security::verifyCSRFToken($_POST['csrf_token'] ?? '')) {
            die('Invalid CSRF token');
        }

        $settingModel = new \App\Models\Setting();
        $keys = [
            'about_seo_title',
            'about_seo_description',
            'about_seo_keywords',
            'about_title',
            'about_description',
            'about_image_title',
            'about_image_subtitle',
            'about_mission_title',
            'about_mission_desc',
            'about_impact_title',
            'about_impact_desc'
        ];

        foreach ($keys as $key) {
            $value = \Core\Security::sanitizeInput($_POST[$key] ?? '');
            $settingModel->updateSetting($key, $value);
        }

        if (isset($_FILES['about_image']) && $_FILES['about_image']['error'] === UPLOAD_ERR_OK) {
            $newPath = \Core\FileHelper::upload($_FILES['about_image'], 'assets/images/about/', ['webp', 'jpg', 'jpeg', 'png']);
            if ($newPath) {
                $settingModel->updateSetting('about_image', '/' . ltrim($newPath, '/'));
            }
        }

        header('Location: /admin/nosotros?success=settings_saved');
        exit;
    }

    public function contactConfig() {
        $settingModel = new \App\Models\Setting();
        $settings = $settingModel->getAll();
        
        return $this->adminView('contact_config', [
            'title' => 'Configuración de Página Contacto',
            'settings' => $settings
        ]);
    }

    public function saveContactConfig() {
        if (!\Core\Security::verifyCSRFToken($_POST['csrf_token'] ?? '')) {
            die('Invalid CSRF token');
        }

        $settingModel = new \App\Models\Setting();
        $keys = [
            'contact_seo_title',
            'contact_seo_description',
            'contact_seo_keywords',
            'contact_heading',
            'contact_description',
            'contact_address_label',
            'contact_address_value',
            'contact_email_label',
            'contact_email_value',
            'contact_phone_label',
            'contact_phone_value',
            'contact_form_heading'
        ];

        foreach ($keys as $key) {
            $value = \Core\Security::sanitizeInput($_POST[$key] ?? '');
            $settingModel->updateSetting($key, $value);
        }

        header('Location: /admin/contacto?success=settings_saved');
        exit;
    }

    public function footerConfigAction() {
        $settingModel = new \App\Models\Setting();
        $settings = $settingModel->getAll();
        
        return $this->adminView('footer_config', [
            'title' => 'Configuración de Pie de Página',
            'settings' => $settings
        ]);
    }

    public function saveFooterConfig() {
        if (!\Core\Security::verifyCSRFToken($_POST['csrf_token'] ?? '')) {
            die('Invalid CSRF token');
        }

        $settingModel = new \App\Models\Setting();
        
        // Save single configurations
        $singleKeys = [
            'footer_description',
            'footer_facebook',
            'footer_instagram',
            'footer_linkedin',
            'footer_twitter',
            'footer_youtube',
            'footer_menu_heading'
        ];

        foreach ($singleKeys as $key) {
            $value = \Core\Security::sanitizeInput($_POST[$key] ?? '');
            $settingModel->updateSetting($key, $value);
        }

        // Save ordered array links
        $titles = $_POST['footer_link_titles'] ?? [];
        $urls = $_POST['footer_link_urls'] ?? [];

        for ($i = 1; $i <= 5; $i++) {
            $index = $i - 1;
            $titleVal = \Core\Security::sanitizeInput($titles[$index] ?? '');
            $urlVal = \Core\Security::sanitizeInput($urls[$index] ?? '');

            $settingModel->updateSetting('footer_link_title_' . $i, $titleVal);
            $settingModel->updateSetting('footer_link_url_' . $i, $urlVal);
        }

        header('Location: /admin/pie-pagina?success=settings_saved');
        exit;
    }

    public function ctaConfig() {
        $settingModel = new \App\Models\Setting();
        $settings = $settingModel->getAll();
        return $this->adminView('cta_config', [
            'title' => 'Llamada a la Acción (CTA) de Inicio',
            'settings' => $settings
        ]);
    }

    public function saveHomeCTA() {
        if (!\Core\Security::verifyCSRFToken($_POST['csrf_token'] ?? '')) {
            die('Invalid CSRF token');
        }

        $settingModel = new \App\Models\Setting();
        $keys = [
            'home_cta_tagline',
            'home_cta_headline',
            'home_cta_description',
            'home_cta_btn1_title',
            'home_cta_btn1_url',
            'home_cta_btn2_title',
            'home_cta_btn2_url'
        ];

        foreach ($keys as $key) {
            if ($key === 'home_cta_headline') {
                $value = \Core\Security::sanitizeHTML($_POST[$key] ?? '');
            } else {
                $value = \Core\Security::sanitizeInput($_POST[$key] ?? '');
            }
            $settingModel->updateSetting($key, $value);
        }

        header('Location: /admin/cta?success=cta_saved');
        exit;
    }
}
