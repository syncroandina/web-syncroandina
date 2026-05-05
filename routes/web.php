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
$router->get('admin/projects', 'AdminController@projects');
