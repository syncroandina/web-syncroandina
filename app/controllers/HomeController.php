<?php
namespace App\Controllers;

use Core\Controller;
use App\Models\Slider;
use App\Models\Project;
use App\Models\BlogPost;
use App\Models\Service;
use App\Models\Setting;
use App\Models\ClientLogo;
use App\Models\HomeGallery;

class HomeController extends Controller {
    public function index() {
        $sliderModel = new Slider();
        $projectModel = new Project();
        $blogModel = new BlogPost();
        $serviceModel = new Service();
        $settingModel = new Setting();
        $clientLogoModel = new ClientLogo();
        $galleryModel = new HomeGallery();

        $sliders = $sliderModel->getActive();
        $latestProjects = $projectModel->getLatest(3);
        $latestPosts = $blogModel->getLatest(3);
        $settings = $settingModel->getAll();
        $limit = isset($settings['services_limit']) ? (int)$settings['services_limit'] : 6;
        $services = $serviceModel->getActive($limit);
        $clientLogos = $clientLogoModel->getActive();
        $galleryItems = $galleryModel->getAll();

        return $this->view('pages/home', [
            'title' => 'Inicio - Syncro Andina',
            'sliders' => $sliders,
            'latestProjects' => $latestProjects,
            'latestPosts' => $latestPosts,
            'services' => $services,
            'settings' => $settings,
            'clientLogos' => $clientLogos,
            'galleryItems' => $galleryItems
        ]);
    }
}
