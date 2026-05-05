<?php
namespace App\Controllers;

use Core\Controller;

class PageController extends Controller {
    public function about() {
        return $this->view('pages/about', ['title' => 'La Empresa - Syncro Andina']);
    }

    public function services() {
        return $this->view('pages/services', ['title' => 'Servicios - Syncro Andina']);
    }

    public function projects() {
        $projectModel = new \App\Models\Project();
        $projects = $projectModel->getAllActive();

        return $this->view('pages/projects', [
            'title' => 'Proyectos - Syncro Andina',
            'projects' => $projects
        ]);
    }

    public function blog() {
        return $this->view('pages/blog', ['title' => 'Blog - Syncro Andina']);
    }

    public function contact() {
        return $this->view('pages/contact', ['title' => 'Contacto - Syncro Andina']);
    }
}
