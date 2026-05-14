<?php
namespace App\Controllers;

use Core\Controller;

class PageController extends Controller {
    public function about() {
        $settingModel = new \App\Models\Setting();
        $settings = $settingModel->getAll();
        
        return $this->view('pages/about', [
            'title' => $settings['about_seo_title'] ?? 'La Empresa - Syncro Andina',
            'description' => $settings['about_seo_description'] ?? 'Syncro Andina: Desarrollo de software premium, transformación digital y modernización cloud para corporaciones.',
            'keywords' => $settings['about_seo_keywords'] ?? 'transformación digital, desarrollo web, software a medida, aplicaciones corporativas',
            'settings' => $settings
        ]);
    }

    public function services() {
        $serviceModel = new \App\Models\Service();
        $settingModel = new \App\Models\Setting();
        
        $services = $serviceModel->getActive();
        $settings = $settingModel->getAll();
        
        return $this->view('pages/services', [
            'title' => 'Servicios - Syncro Andina',
            'services' => $services,
            'settings' => $settings
        ]);
    }

    public function serviceDetail($slug) {
        $serviceModel = new \App\Models\Service();
        $settingModel = new \App\Models\Setting();
        
        $results = $serviceModel->where('slug', $slug);
        $service = !empty($results) ? $results[0] : null;
        
        if (!$service) {
            http_response_code(404);
            echo "<h1>404 Not Found</h1><p>El servicio solicitado no existe.</p>";
            exit;
        }
        
        $service = $serviceModel->getFullDetails($service['id']);
        $settings = $settingModel->getAll();
        
        return $this->view('pages/service_detail', [
            'title' => $service['title'] . ' - Syncro Andina',
            'service' => $service,
            'settings' => $settings
        ]);
    }

    public function projects() {
        $projectModel = new \App\Models\Project();
        $settingModel = new \App\Models\Setting();
        $projects = $projectModel->getAllActive();
        $settings = $settingModel->getAll();

        return $this->view('pages/projects', [
            'title' => 'Proyectos - Syncro Andina',
            'projects' => $projects,
            'settings' => $settings
        ]);
    }

    public function projectDetail($slug) {
        $projectModel = new \App\Models\Project();
        $settingModel = new \App\Models\Setting();
        
        $results = $projectModel->where('slug', $slug);
        $project = !empty($results) ? $results[0] : null;
        
        if (!$project || !$project['is_active']) {
            http_response_code(404);
            echo "<h1>404 Not Found</h1><p>El proyecto solicitado no existe o no está activo.</p>";
            exit;
        }
        
        $settings = $settingModel->getAll();
        $galleryModel = new \App\Models\ProjectGallery();
        $gallery = $galleryModel->getByProject($project['id']);
        
        return $this->view('pages/project_detail', [
            'title' => $project['title'] . ' - Syncro Andina',
            'project' => $project,
            'settings' => $settings,
            'gallery' => $gallery
        ]);
    }

    public function products() {
        $productModel = new \App\Models\Product();
        $settingModel = new \App\Models\Setting();
        $products = $productModel->getAllActive();
        $settings = $settingModel->getAll();

        return $this->view('pages/products', [
            'title' => ($settings['page_products_title'] ?? 'Repuestos y Componentes') . ' - Syncro Andina',
            'products' => $products,
            'settings' => $settings
        ]);
    }

    public function productDetail($slug) {
        $productModel = new \App\Models\Product();
        $settingModel = new \App\Models\Setting();
        
        $product = $productModel->findBySlug($slug);
        
        if (!$product || !$product['is_active']) {
            http_response_code(404);
            echo "<h1>404 Not Found</h1><p>El repuesto solicitado no existe o no está activo.</p>";
            exit;
        }
        
        $settings = $settingModel->getAll();
        $galleryModel = new \App\Models\ProductGallery();
        $gallery = $galleryModel->getByProduct($product['id']);
        
        return $this->view('pages/product_detail', [
            'title' => $product['title'] . ' - Syncro Andina',
            'product' => $product,
            'settings' => $settings,
            'gallery' => $gallery
        ]);
    }

    public function blog() {
        $postModel = new \App\Models\BlogPost();
        $catModel = new \App\Models\BlogCategory();
        $settingModel = new \App\Models\Setting();
        
        $categories = $catModel->getAll();
        
        // Capturar categoría de la URL si existe
        $currentCatSlug = isset($_GET['categoria']) ? $_GET['categoria'] : null;
        $categoryId = null;
        $currentCategory = null;

        if ($currentCatSlug) {
            // Buscar el ID de la categoría por el slug
            foreach ($categories as $cat) {
                if ($cat['slug'] === $currentCatSlug) {
                    $categoryId = $cat['id'];
                    $currentCategory = $cat;
                    break;
                }
            }
        }

        // Capturar búsqueda
        $search = isset($_GET['s']) ? trim($_GET['s']) : null;

        $posts = $postModel->getPublished(null, $categoryId, $search);
        $settings = $settingModel->getAll();

        return $this->view('pages/blog', [
            'title' => 'Blog - Syncro Andina',
            'posts' => $posts,
            'settings' => $settings,
            'categories' => $categories,
            'activeCategory' => $currentCatSlug,
            'categoryData' => $currentCategory,
            'search' => $search
        ]);
    }

    public function blogDetail($slug) {
        $postModel = new \App\Models\BlogPost();
        $settingModel = new \App\Models\Setting();
        
        $results = $postModel->where('slug', $slug);
        $post = !empty($results) ? $results[0] : null;

        if (!$post || $post['status'] !== 'published' || !empty($post['deleted_at'])) {
            http_response_code(404);
            echo "<h1>404 Not Found</h1><p>El artículo solicitado no existe o no se encuentra disponible.</p>";
            exit;
        }

        // Obtener posts relacionados (misma categoría, excluyendo el actual)
        $db = (new \App\Models\BlogPost());
        $catId = $post['category_id'] ?? null;
        
        $recSql = "SELECT p.*, u.name as author_name 
                   FROM blog_posts p 
                   LEFT JOIN users u ON p.author_id = u.id
                   WHERE p.status = 'published' AND p.deleted_at IS NULL AND p.id != ?";
        
        $params = [$post['id']];
        if ($catId) {
            $recSql .= " AND p.category_id = ?";
            $params[] = $catId;
        }
        
        $recSql .= " ORDER BY p.published_at DESC LIMIT 3";
        
        $stmt = $db->db->prepare($recSql);
        $stmt->execute($params);
        $recommended = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $settings = $settingModel->getAll();

        return $this->view('pages/blog_detail', [
            'title' => $post['title'] . ' - Syncro Andina',
            'post' => $post,
            'recommended' => $recommended,
            'settings' => $settings
        ]);
    }

    public function contact() {
        $settingModel = new \App\Models\Setting();
        $serviceModel = new \App\Models\Service();
        $settings = $settingModel->getAll();
        $services = $serviceModel->getActive();

        return $this->view('pages/contact', [
            'title' => $settings['contact_seo_title'] ?? 'Contacto - Syncro Andina',
            'description' => $settings['contact_seo_description'] ?? 'Ponte en contacto con Syncro Andina. Solicita información comercial o de soporte técnico para escalar la tecnología de tu empresa.',
            'keywords' => $settings['contact_seo_keywords'] ?? 'contacto, cotización, soporte corporativo, syncro andina',
            'settings' => $settings,
            'services' => $services
        ]);
    }

    public function saveContact() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Método no permitido.']);
            exit;
        }

        // Verificar token CSRF
        if (!\Core\Security::verifyCSRFToken($_POST['csrf_token'] ?? '')) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Token de seguridad inválido. Por favor, recargue la página e intente nuevamente.']);
            exit;
        }

        $contactModel = new \App\Models\Contact();

        // Sanitización y obtención de variables
        $name = \Core\Security::sanitizeInput($_POST['name'] ?? '');
        $email = \Core\Security::sanitizeInput($_POST['email'] ?? '');
        $phone = \Core\Security::sanitizeInput($_POST['phone'] ?? '');
        $subject = \Core\Security::sanitizeInput($_POST['subject'] ?? '');
        $message = \Core\Security::sanitizeInput($_POST['message'] ?? '');
        $clientType = \Core\Security::sanitizeInput($_POST['client_type'] ?? 'persona');
        $ruc = ($clientType === 'empresa') ? \Core\Security::sanitizeInput($_POST['ruc'] ?? '') : null;
        $serviceId = !empty($_POST['service_id']) ? (int)$_POST['service_id'] : null;

        // Validaciones básicas
        if (empty($name) || empty($email) || empty($phone)) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'El nombre completo, correo electrónico y teléfono/WhatsApp son obligatorios.']);
            exit;
        }

        if ($clientType === 'empresa' && empty($ruc)) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'El número de RUC es obligatorio para empresas.']);
            exit;
        }

        $data = [
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'subject' => $subject,
            'message' => $message,
            'client_type' => $clientType,
            'ruc' => $ruc,
            'service_id' => $serviceId
        ];

        $savedId = $contactModel->save($data);

        header('Content-Type: application/json');
        if ($savedId) {
            echo json_encode(['success' => true, 'message' => '¡Tu mensaje ha sido enviado con éxito! Un especialista se pondrá en contacto contigo muy pronto.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Hubo un error al registrar tu contacto. Por favor, inténtalo de nuevo más tarde.']);
        }
        exit;
    }

    public function thanks() {
        $settingModel = new \App\Models\Setting();
        $settings = $settingModel->getAll();
        
        return $this->view('pages/thanks', [
            'title' => '¡Muchas Gracias! - Syncro Andina',
            'description' => 'Gracias por ponerte en contacto con Syncro Andina. Tu mensaje ha sido recibido.',
            'settings' => $settings
        ]);
    }
}
