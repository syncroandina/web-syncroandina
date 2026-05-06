<?php
/** @var \Core\Router $router */

$router->get('', 'HomeController@index');
$router->get('nosotros', 'PageController@about');
$router->get('servicios', 'PageController@services');
$router->get('servicios/{slug}', 'PageController@serviceDetail');
$router->get('proyectos', 'PageController@projects');
$router->get('blog', 'PageController@blog');
$router->get('contacto', 'PageController@contact');
$router->get('iniciar-sesion', 'AuthController@login');
$router->post('iniciar-sesion', 'AuthController@authenticate');
$router->get('cerrar-sesion', 'AuthController@logout');

// Admin
$router->get('admin', 'AdminController@dashboard');
$router->get('admin/escritorio', 'AdminController@dashboard');

// Sliders
$router->get('admin/sliders', 'AdminController@sliders');
$router->post('admin/sliders/save', 'AdminController@saveSlider');
$router->post('admin/sliders/delete', 'AdminController@deleteSlider');
$router->post('admin/sliders/duplicate', 'AdminController@duplicateSlider');
$router->post('admin/sliders/toggle', 'AdminController@toggleSliderStatus');
$router->post('admin/sliders/reorder', 'AdminController@reorderSliders');

// Servicios
$router->get('admin/servicios', 'AdminController@services');
$router->get('admin/servicios/get', 'AdminController@getService');
$router->post('admin/servicios', 'AdminController@saveService');
$router->post('admin/servicios/delete', 'AdminController@deleteService');
$router->post('admin/servicios/duplicate', 'AdminController@duplicateService');
$router->post('admin/servicios/toggle', 'AdminController@toggleServiceStatus');
$router->post('admin/servicios/reorder', 'AdminController@reorderServices');
$router->post('admin/servicios/gallery/delete', 'AdminController@deleteGalleryImage');
$router->post('admin/servicios/settings', 'AdminController@saveServiceSettings');

// Proyectos
$router->get('admin/proyectos', 'AdminController@projects');
$router->post('admin/proyectos', 'AdminController@saveProject');
$router->post('admin/proyectos/delete', 'AdminController@deleteProject');

// Identidad Corporativa
$router->get('admin/identidad', 'AdminController@identityConfig');
$router->post('admin/identidad/images', 'AdminController@saveIdentityImages');
$router->post('admin/identidad/images/delete', 'AdminController@deleteIdentityImage');
$router->post('admin/identidad/colors', 'AdminController@saveColors');
$router->post('admin/identidad/typography', 'AdminController@saveTypography');

// Header
$router->get('admin/cabecera', 'AdminController@headerConfig');
$router->post('admin/cabecera/phone', 'AdminController@savePhone');
$router->post('admin/cabecera/menu', 'AdminController@saveMenuLink');
$router->post('admin/cabecera/menu/delete', 'AdminController@deleteMenuLink');
$router->post('admin/cabecera/menu/reorder', 'AdminController@reorderMenuLinks');

// Nosotros
$router->get('admin/nosotros', 'AdminController@aboutConfig');
$router->post('admin/nosotros/save', 'AdminController@saveAboutConfig');

// Contacto
$router->get('admin/contacto', 'AdminController@contactConfig');
$router->post('admin/contacto/save', 'AdminController@saveContactConfig');

// Footer
$router->get('admin/pie-pagina', 'AdminController@footerConfigAction');
$router->post('admin/pie-pagina/save', 'AdminController@saveFooterConfig');
