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
        $projects = $projectModel->getAllActive();
        return $this->adminView('projects/index', [
            'title' => 'Gestión de Proyectos',
            'projects' => $projects
        ]);
    }

    public function services() {
        $serviceModel = new \App\Models\Service();
        $settingModel = new \App\Models\Setting();
        $services = $serviceModel->getActive();
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
        $keys = ['services_label', 'services_title', 'services_description'];

        foreach ($keys as $key) {
            $value = \Core\Security::sanitizeInput($_POST[$key] ?? '');
            $settingModel->updateSetting($key, $value);
        }

        header('Location: /admin/services?success=settings_saved');
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
            'content' => \Core\Security::sanitizeInput($_POST['content'] ?? ''),
            'is_active' => isset($_POST['is_active']) ? 1 : 0
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

        header('Location: /admin/services?success=service_saved');
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

        header('Location: /admin/services?success=service_deleted');
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
        $sliders = $sliderModel->getAll();
        return $this->adminView('sliders/index', [
            'title' => 'Gestión de Sliders',
            'sliders' => $sliders
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
            'completion_date' => \Core\Security::sanitizeInput($_POST['completion_date'] ?? ''),
            'is_active' => isset($_POST['is_active']) ? 1 : 0
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
        $projectModel->save($data);

        header('Location: /admin/projects?success=project_saved');
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

        header('Location: /admin/projects?success=project_deleted');
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
            header('Location: /admin/identity?error=' . $error);
        } elseif ($updated) {
            header('Location: /admin/identity?success=images_saved');
        } else {
            header('Location: /admin/identity?info=no_changes');
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
            header('Location: /admin/identity?success=image_deleted');
        } else {
            header('Location: /admin/identity?error=not_found');
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

        header('Location: /admin/identity?success=colors_saved');
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

        header('Location: /admin/identity?success=typography_saved');
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

        header('Location: /admin/header?success=phone_saved');
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

        header('Location: /admin/header?success=link_saved');
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
        
        header('Location: /admin/header?success=link_deleted');
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
}
