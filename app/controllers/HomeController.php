<?php
namespace App\Controllers;

use Core\Controller;
use App\Models\Slider;
use App\Models\Project;
use App\Models\BlogPost;
use App\Models\Service;
use App\Models\Setting;

class HomeController extends Controller {
    public function index() {
        $sliderModel = new Slider();
        $projectModel = new Project();
        $blogModel = new BlogPost();
        $serviceModel = new Service();
        $settingModel = new Setting();

        $sliders = $sliderModel->getActive();
        $latestProjects = $projectModel->getLatest(3);
        $latestPosts = $blogModel->getLatest(3);
        $services = $serviceModel->getActive();
        $settings = $settingModel->getAll();

        return $this->view('pages/home', [
            'title' => 'Inicio - Syncro Andina',
            'sliders' => $sliders,
            'latestProjects' => $latestProjects,
            'latestPosts' => $latestPosts,
            'services' => $services,
            'settings' => $settings
        ]);
    }
}
