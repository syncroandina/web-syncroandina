<?php
/** @var \Core\Router $router */

$router->get('', 'HomeController@index');
$router->get('about', 'PageController@about');
$router->get('services', 'PageController@services');
$router->get('projects', 'PageController@projects');
$router->get('blog', 'PageController@blog');
$router->get('contact', 'PageController@contact');
$router->get('login', 'AuthController@login');
$router->post('login', 'AuthController@authenticate');
$router->get('logout', 'AuthController@logout');

// Admin
$router->get('admin', 'AdminController@dashboard');
$router->get('admin/dashboard', 'AdminController@dashboard');

// Sliders
$router->get('admin/sliders', 'AdminController@sliders');
$router->post('admin/sliders/save', 'AdminController@saveSlider');
$router->post('admin/sliders/delete', 'AdminController@deleteSlider');
$router->post('admin/sliders/toggle', 'AdminController@toggleSliderStatus');
$router->post('admin/sliders/reorder', 'AdminController@reorderSliders');

// Servicios
$router->get('admin/services', 'AdminController@services');
$router->get('admin/services/get', 'AdminController@getService');
$router->post('admin/services', 'AdminController@saveService');
$router->post('admin/services/delete', 'AdminController@deleteService');
$router->post('admin/services/gallery/delete', 'AdminController@deleteGalleryImage');
$router->post('admin/services/settings', 'AdminController@saveServiceSettings');

// Proyectos
$router->get('admin/projects', 'AdminController@projects');
$router->post('admin/projects', 'AdminController@saveProject');
$router->post('admin/projects/delete', 'AdminController@deleteProject');

// Identidad Corporativa
$router->get('admin/identity', 'AdminController@identityConfig');
$router->post('admin/identity/images', 'AdminController@saveIdentityImages');
$router->post('admin/identity/images/delete', 'AdminController@deleteIdentityImage');
$router->post('admin/identity/colors', 'AdminController@saveColors');
$router->post('admin/identity/typography', 'AdminController@saveTypography');

// Header
$router->get('admin/header', 'AdminController@headerConfig');
$router->post('admin/header/phone', 'AdminController@savePhone');
$router->post('admin/header/menu', 'AdminController@saveMenuLink');
$router->post('admin/header/menu/delete', 'AdminController@deleteMenuLink');
$router->post('admin/header/menu/reorder', 'AdminController@reorderMenuLinks');
