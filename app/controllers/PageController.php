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

    public function blog() {
        $postModel = new \App\Models\BlogPost();
        $settingModel = new \App\Models\Setting();
        $posts = $postModel->getPublished();
        $settings = $settingModel->getAll();

        return $this->view('pages/blog', [
            'title' => 'Blog - Syncro Andina',
            'posts' => $posts,
            'settings' => $settings
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

        // Obtener posts recomendados (los últimos 3 excluyendo el actual)
        $db = (new \App\Models\BlogPost());
        $recSql = "SELECT p.*, u.name as author_name 
                   FROM blog_posts p 
                   LEFT JOIN users u ON p.author_id = u.id
                   WHERE p.status = 'published' AND p.deleted_at IS NULL AND p.id != ? 
                   ORDER BY p.published_at DESC LIMIT 3";
        $stmt = $db->db->prepare($recSql);
        $stmt->execute([$post['id']]);
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
        $settings = $settingModel->getAll();

        return $this->view('pages/contact', [
            'title' => $settings['contact_seo_title'] ?? 'Contacto - Syncro Andina',
            'description' => $settings['contact_seo_description'] ?? 'Ponte en contacto con Syncro Andina. Solicita información comercial o de soporte técnico para escalar la tecnología de tu empresa.',
            'keywords' => $settings['contact_seo_keywords'] ?? 'contacto, cotización, soporte corporativo, syncro andina',
            'settings' => $settings
        ]);
    }
}
