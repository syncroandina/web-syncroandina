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
use App\Models\Product;
use App\Models\Analytics;

class HomeController extends Controller {
    public function index() {
        $sliderModel = new Slider();
        $projectModel = new Project();
        $blogModel = new BlogPost();
        $serviceModel = new Service();
        $settingModel = new Setting();
        $clientLogoModel = new ClientLogo();
        $galleryModel = new HomeGallery();
        $productModel = new Product();
        $analytics = new Analytics();

        $analytics->logPageView('home', null, '/', $_SERVER['REMOTE_ADDR'] ?? '', $_SERVER['HTTP_USER_AGENT'] ?? '');

        $sliders = $sliderModel->getActive();
        $latestProjects = $projectModel->getLatest(6);
        $latestPosts = $blogModel->getLatest(8);
        $settings = $settingModel->getAll();
        $services = $serviceModel->getActive();
        $clientLogos = $clientLogoModel->getActive();
        $galleryItems = $galleryModel->getAll();
        $featuredProducts = $productModel->getAllActive();

        return $this->view('pages/home', [
            'title' => !empty($settings['home_seo_title']) ? $settings['home_seo_title'] : 'Inicio - Syncro Andina',
            'description' => !empty($settings['home_seo_description']) ? $settings['home_seo_description'] : null,
            'keywords' => !empty($settings['home_seo_keywords']) ? $settings['home_seo_keywords'] : null,
            'sliders' => $sliders,
            'latestProjects' => $latestProjects,
            'latestPosts' => $latestPosts,
            'services' => $services,
            'settings' => $settings,
            'clientLogos' => $clientLogos,
            'galleryItems' => $galleryItems,
            'featuredProducts' => $featuredProducts
        ]);
    }
}
