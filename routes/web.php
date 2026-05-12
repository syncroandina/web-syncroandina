<?php
/** @var \Core\Router $router */

$router->get('', 'HomeController@index');
$router->get('nosotros', 'PageController@about');
$router->get('servicios', 'PageController@services');
$router->get('servicios/{slug}', 'PageController@serviceDetail');
$router->get('proyectos', 'PageController@projects');
$router->get('proyectos/{slug}', 'PageController@projectDetail');
$router->get('blog', 'PageController@blog');
$router->get('blog/{slug}', 'PageController@blogDetail');
$router->get('contacto', 'PageController@contact');
$router->post('contacto', 'PageController@saveContact');
$router->get('gracias', 'PageController@thanks');
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
$router->get('admin/cta', 'AdminController@ctaConfig');
$router->post('admin/cta/save', 'AdminController@saveHomeCTA');

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

// Galería General
$router->get('admin/galeria', 'AdminController@homeGallery');
$router->post('admin/galeria/save', 'AdminController@saveHomeGalleryImage');
$router->post('admin/galeria/delete', 'AdminController@deleteHomeGalleryImage');
$router->post('admin/galeria/reorder', 'AdminController@reorderHomeGallery');

// Proyectos
$router->get('admin/proyectos', 'AdminController@projects');
$router->post('admin/proyectos', 'AdminController@saveProject');
$router->post('admin/proyectos/delete', 'AdminController@deleteProject');
$router->post('admin/proyectos/duplicate', 'AdminController@duplicateProject');
$router->post('admin/proyectos/settings', 'AdminController@saveProjectSettings');
$router->post('admin/proyectos/gallery/delete', 'AdminController@deleteProjectGalleryImage');

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

// Gestión de Leads / Contactos
$router->get('admin/contactos', 'AdminController@leadsList');
$router->post('admin/contactos/toggle-read', 'AdminController@toggleLeadRead');
$router->post('admin/contactos/delete', 'AdminController@deleteLead');
$router->get('admin/contactos/exportar', 'AdminController@exportLeads');

// Footer
$router->get('admin/pie-pagina', 'AdminController@footerConfigAction');
$router->post('admin/pie-pagina/save', 'AdminController@saveFooterConfig');

// Blog CRUD Admin
$router->get('admin/blog', 'AdminController@blog');
$router->post('admin/blog/save', 'AdminController@savePost');
$router->post('admin/blog/delete', 'AdminController@deletePost');
$router->post('admin/blog/toggle', 'AdminController@togglePostStatus');
$router->post('admin/blog/duplicate', 'AdminController@duplicatePost');
$router->post('admin/blog/settings', 'AdminController@saveBlogSettings');
$router->post('admin/blog/categorias/save', 'AdminController@saveBlogCategory');
$router->post('admin/blog/categorias/delete', 'AdminController@deleteBlogCategory');

// Clientes (Logos)
$router->get('admin/clientes', 'AdminController@clientsList');
$router->post('admin/clientes/save', 'AdminController@saveClientLogo');
$router->post('admin/clientes/delete', 'AdminController@deleteClientLogo');
$router->post('admin/clientes/reorder', 'AdminController@reorderClientLogos');
$router->post('admin/clientes/settings', 'AdminController@saveClientSliderSettings');

// Call Center (Flotante)
$router->get('admin/call-center', 'AdminController@callCenterList');
$router->post('admin/call-center/save', 'AdminController@saveCallCenterContact');
$router->post('admin/call-center/delete', 'AdminController@deleteCallCenterContact');
$router->post('admin/call-center/reorder', 'AdminController@reorderCallCenterContacts');
$router->post('admin/call-center/settings', 'AdminController@saveCallCenterSettings');

