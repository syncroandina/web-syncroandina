<?php
namespace App\Controllers;

use Core\Controller;
use App\Models\Analytics;

class PageController extends Controller {
    public function about() {
        (new Analytics())->logPageView('about', null, $_SERVER['REQUEST_URI'] ?? '/nosotros', $_SERVER['REMOTE_ADDR'] ?? '', $_SERVER['HTTP_USER_AGENT'] ?? '');

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
        (new Analytics())->logPageView('services', null, $_SERVER['REQUEST_URI'] ?? '/servicios', $_SERVER['REMOTE_ADDR'] ?? '', $_SERVER['HTTP_USER_AGENT'] ?? '');

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
        
        (new Analytics())->logPageView('service', $service['id'], $_SERVER['REQUEST_URI'] ?? '', $_SERVER['REMOTE_ADDR'] ?? '', $_SERVER['HTTP_USER_AGENT'] ?? '');
        $service = $serviceModel->getFullDetails($service['id']);
        $settings = $settingModel->getAll();
        
        return $this->view('pages/service_detail', [
            'title' => $service['title'] . ' - Syncro Andina',
            'service' => $service,
            'settings' => $settings
        ]);
    }

    public function projects() {
        (new Analytics())->logPageView('projects', null, $_SERVER['REQUEST_URI'] ?? '/proyectos', $_SERVER['REMOTE_ADDR'] ?? '', $_SERVER['HTTP_USER_AGENT'] ?? '');

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
        
        (new Analytics())->logPageView('project', $project['id'], $_SERVER['REQUEST_URI'] ?? '', $_SERVER['REMOTE_ADDR'] ?? '', $_SERVER['HTTP_USER_AGENT'] ?? '');
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
        (new Analytics())->logPageView('products', null, $_SERVER['REQUEST_URI'] ?? '/repuestos', $_SERVER['REMOTE_ADDR'] ?? '', $_SERVER['HTTP_USER_AGENT'] ?? '');

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
        
        (new Analytics())->logPageView('product', $product['id'], $_SERVER['REQUEST_URI'] ?? '', $_SERVER['REMOTE_ADDR'] ?? '', $_SERVER['HTTP_USER_AGENT'] ?? '');
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
        (new Analytics())->logPageView('blog_index', null, $_SERVER['REQUEST_URI'] ?? '/blog', $_SERVER['REMOTE_ADDR'] ?? '', $_SERVER['HTTP_USER_AGENT'] ?? '');

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

        (new Analytics())->logPageView('blog', $post['id'], $_SERVER['REQUEST_URI'] ?? '', $_SERVER['REMOTE_ADDR'] ?? '', $_SERVER['HTTP_USER_AGENT'] ?? '');

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
        (new Analytics())->logPageView('contact', null, $_SERVER['REQUEST_URI'] ?? '/contacto', $_SERVER['REMOTE_ADDR'] ?? '', $_SERVER['HTTP_USER_AGENT'] ?? '');

        $settingModel = new \App\Models\Setting();
        $serviceModel = new \App\Models\Service();
        $projectModel = new \App\Models\Project();
        $productModel = new \App\Models\Product();

        $settings = $settingModel->getAll();
        $services = $serviceModel->getActive();
        $projects = $projectModel->getAllActive();
        $products = $productModel->getAllActive();

        return $this->view('pages/contact', [
            'title' => $settings['contact_seo_title'] ?? 'Contacto - Syncro Andina',
            'description' => $settings['contact_seo_description'] ?? 'Ponte en contacto con Syncro Andina. Solicita información comercial o de soporte técnico para escalar la tecnología de tu empresa.',
            'keywords' => $settings['contact_seo_keywords'] ?? 'contacto, cotización, soporte corporativo, syncro andina',
            'settings' => $settings,
            'services' => $services,
            'projects' => $projects,
            'products' => $products
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
        $settingModel = new \App\Models\Setting();

        // Sanitización y obtención de variables
        $name = \Core\Security::sanitizeInput($_POST['name'] ?? '');
        $email = \Core\Security::sanitizeInput($_POST['email'] ?? '');
        $phone = \Core\Security::sanitizeInput($_POST['phone'] ?? '');
        $subject = \Core\Security::sanitizeInput($_POST['subject'] ?? '');
        $message = \Core\Security::sanitizeInput($_POST['message'] ?? '');
        $clientType = \Core\Security::sanitizeInput($_POST['client_type'] ?? 'persona');
        $ruc = ($clientType === 'empresa') ? \Core\Security::sanitizeInput($_POST['ruc'] ?? '') : null;
        
        // Carga inteligente del interés contextual
        $interestType = \Core\Security::sanitizeInput($_POST['interest_type'] ?? 'general');
        $serviceId = ($interestType === 'servicio' && !empty($_POST['service_id'])) ? (int)$_POST['service_id'] : null;
        $projectId = ($interestType === 'proyecto' && !empty($_POST['project_id'])) ? (int)$_POST['project_id'] : null;
        $productId = ($interestType === 'producto' && !empty($_POST['product_id'])) ? (int)$_POST['product_id'] : null;

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
            'service_id' => $serviceId,
            'project_id' => $projectId,
            'product_id' => $productId
        ];

        $savedId = $contactModel->save($data);

        if ($savedId) {
            try {
                // Configuración de notificaciones
                $settings = $settingModel->getAll();
                $logoUrl = $settings['logo_url'] ?? '/assets/images/logo.webp';
                $fromName = $settings['notification_sender_name'] ?? 'Syncro Andina';
                
                // Color de acento dinámico de la marca (rojo de la identidad corporativa)
                $accentColor = $settings['color_secondary'] ?? ($settings['color_accent'] ?? '#D80000');

                // Obtener detalle dinámico del interés contextual
                $interestDetailHtml = '';
                if ($serviceId) {
                    $serviceModel = new \App\Models\Service();
                    $svc = $serviceModel->find($serviceId);
                    if ($svc) {
                        $interestDetailHtml = "
                        <div class='field-row'>
                            <span class='field-label'>Servicio de Interés:</span>
                            <span class='field-value'><strong>" . htmlspecialchars($svc['title']) . "</strong></span>
                        </div>";
                    }
                } elseif ($projectId) {
                    $projectModel = new \App\Models\Project();
                    $proj = $projectModel->find($projectId);
                    if ($proj) {
                        $interestDetailHtml = "
                        <div class='field-row'>
                            <span class='field-label'>Proyecto de Interés:</span>
                            <span class='field-value'><strong>" . htmlspecialchars($proj['title']) . "</strong></span>
                        </div>";
                    }
                } elseif ($productId) {
                    $productModel = new \App\Models\Product();
                    $prod = $productModel->find($productId);
                    if ($prod) {
                        $interestDetailHtml = "
                        <div class='field-row'>
                            <span class='field-label'>Repuesto de Interés:</span>
                            <span class='field-value'><strong>" . htmlspecialchars($prod['title']) . "</strong></span>
                        </div>";
                    }
                } else {
                    $interestDetailHtml = "
                    <div class='field-row'>
                        <span class='field-label'>Tipo de Consulta:</span>
                        <span class='field-value'><strong>Consulta General / Otros</strong></span>
                    </div>";
                }

                $dateStr = date('d/m/Y H:i:s');
                $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";
                $host = $_SERVER['HTTP_HOST'] ?? 'localhost:8000';
                $adminUrl = $protocol . $host . '/admin/contactos';

                // 1. Notificación a la Empresa (Administrador)
                $enableAdmin = $settings['notification_enable_admin'] ?? '1';
                if ($enableAdmin == '1') {
                    $toEmails = $settings['notification_emails'] ?? 'contacto@syncroandina.com';
                    
                    $rucHtml = '';
                    if ($clientType === 'empresa' && !empty($ruc)) {
                        $rucHtml = "
                        <div class='field-row'>
                            <span class='field-label'>RUC:</span>
                            <span class='field-value'>{$ruc}</span>
                        </div>";
                    }

                    $adminContent = "
                    <p>Se ha registrado un nuevo mensaje de contacto en el sitio web de <strong>Syncro Andina</strong>. A continuación, se detallan los datos del solicitante:</p>
                    <div class='card'>
                        <div class='card-title'>Datos del Mensaje</div>
                        <div class='field-row'>
                            <span class='field-label'>Nombre:</span>
                            <span class='field-value'>{$name}</span>
                        </div>
                        <div class='field-row'>
                            <span class='field-label'>Email:</span>
                            <span class='field-value'><a href='mailto:{$email}'>{$email}</a></span>
                        </div>
                        <div class='field-row'>
                            <span class='field-label'>Teléfono:</span>
                            <span class='field-value'>{$phone}</span>
                        </div>
                        <div class='field-row'>
                            <span class='field-label'>Tipo Cliente:</span>
                            <span class='field-value'>" . ucfirst($clientType) . "</span>
                        </div>
                        {$rucHtml}
                        {$interestDetailHtml}
                        <div class='field-row'>
                            <span class='field-label'>Asunto:</span>
                            <span class='field-value'><strong>{$subject}</strong></span>
                        </div>
                        <div class='field-row'>
                            <span class='field-label'>Fecha:</span>
                            <span class='field-value'>{$dateStr}</span>
                        </div>
                    </div>
                    <div class='card'>
                        <div class='card-title'>Mensaje Recibido</div>
                        <p style='margin: 0; white-space: pre-wrap; font-size: 14px; line-height: 1.6; color: #334155;'>{$message}</p>
                    </div>
                    <div class='btn-container'>
                        <a href='{$adminUrl}' class='btn'>Ver en el Panel de Administración</a>
                    </div>";

                    $adminHtml = \Core\MailHelper::getTemplate(
                        "¡Nuevo Mensaje de Contacto Recibido!", 
                        $adminContent, 
                        $logoUrl, 
                        $accentColor
                    );

                    \Core\MailHelper::send($toEmails, "Nuevo contacto: " . $subject, $adminHtml, $fromName);
                }

                // 2. Respuesta Automática al Cliente
                $enableClient = $settings['notification_enable_client'] ?? '1';
                if ($enableClient == '1' && filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $clientContent = "
                    <p>Hola <strong>{$name}</strong>,</p>
                    <p>Queremos confirmarte que hemos recibido tu solicitud de contacto correctamente en nuestro sistema comercial.</p>
                    <p>Un especialista técnico de nuestro equipo evaluará tu consulta y se pondrá en contacto contigo en las próximas horas para ofrecerte la asesoría adecuada.</p>
                    <div class='card'>
                        <div class='card-title'>Resumen de tu Consulta</div>
                        <div class='field-row'>
                            <span class='field-label'>Asunto:</span>
                            <span class='field-value'><strong>{$subject}</strong></span>
                        </div>
                        {$interestDetailHtml}
                    </div>
                    <p>Agradecemos tu confianza en <strong>Syncro Andina</strong> para el soporte técnico y comercial de tus proyectos industriales.</p>
                    <p>Atentamente,<br><strong>El Equipo de Syncro Andina</strong></p>";

                    $clientHtml = \Core\MailHelper::getTemplate(
                        "¡Hemos recibido tu mensaje con éxito!", 
                        $clientContent, 
                        $logoUrl, 
                        $accentColor
                    );

                    \Core\MailHelper::send($email, "Confirmación de contacto - " . $fromName, $clientHtml, $fromName);
                }

            } catch (\Exception $mailEx) {
                // Ignorar o registrar error de envío para no bloquear la respuesta de éxito
            }
        }

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
