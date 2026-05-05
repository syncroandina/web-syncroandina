<?php
namespace App\Controllers;

use Core\Controller;
use App\Models\Slider;
use App\Models\Project;

class HomeController extends Controller {
    public function index() {
        $sliderModel = new Slider();
        $projectModel = new Project();

        $sliders = $sliderModel->getActive();
        $latestProjects = $projectModel->getLatest(3);

        return $this->view('pages/home', [
            'title' => 'Inicio - Syncro Andina',
            'sliders' => $sliders,
            'latestProjects' => $latestProjects
        ]);
    }
}
