<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// LOGIN
$routes->get('/', 'LoginController::index');
$routes->post('login/auth', 'LoginController::autenticar');
$routes->get('logout', 'LoginController::logout');

// TALLER
$routes->get('tecnicos', 'TecnicosController::index', ['filter' => 'auth']);
$routes->get('tecnicos/cambiar_estado/(:any)', 'TecnicosController::cambiar_estado/$1');
$routes->get('tecnicos/marcar_completa/(:num)', 'TecnicosController::marcar_completa/$1');
$routes->post('tecnicos/crear_orden', 'TecnicosController::crear_orden');
$routes->get('tecnicos/orden/(:num)', 'TecnicosController::orden/$1');

$routes->get('jefe-taller', 'JefeTallerController::index', ['filter' => 'auth']);
$routes->get('jefe-taller/ver_tecnico/(:num)', 'JefeTallerController::ver_tecnico/$1');
$routes->get('jefe-taller/asignar_trabajo/(:num)', 'JefeTallerController::asignar_trabajo/$1');
$routes->post('jefe-taller/guardar_trabajo', 'JefeTallerController::guardar_trabajo');
$routes->get('jefe-taller/ver_orden/(:num)', 'JefeTallerController::ver_orden/$1');
$routes->get('jefe-taller/enviar_gerencia/(:num)', 'JefeTallerController::enviar_gerencia/$1');
$routes->post('jefe-taller/guardar_cronograma', 'JefeTallerController::guardar_cronograma');


// VENTAS
$routes->get('vendedores', 'VendedorController::index', ['filter' => 'auth']);
$routes->get('jefe-ventas', 'JefeVentasController::index', ['filter' => 'auth']);

// GERENTE GENERAL
$routes->get('gerente-general', 'GerenteGeneralController::index', ['filter' => 'auth']);

// --- CRUD de Usuarios (solo accesibles para la gerente general) ---
$routes->get('gerente-general/usuarios', 'UsuarioController::index', ['filter' => 'auth']);
$routes->get('gerente-general/usuarios/crear', 'UsuarioController::crear', ['filter' => 'auth']);
$routes->post('gerente-general/usuarios/guardar', 'UsuarioController::guardar', ['filter' => 'auth']);
$routes->get('gerente-general/usuarios/editar/(:num)', 'UsuarioController::editar/$1', ['filter' => 'auth']);
$routes->post('gerente-general/usuarios/actualizar/(:num)', 'UsuarioController::actualizar/$1', ['filter' => 'auth']);
$routes->get('gerente-general/usuarios/eliminar/(:num)', 'UsuarioController::eliminar/$1', ['filter' => 'auth']);

// DUEÑA
$routes->get('duenia', 'DuenaController::index', ['filter' => 'auth']);
$routes->get('duenia/departamento/(:segment)', 'DuenaController::verDepartamento/$1', ['filter' => 'auth']);
$routes->get('duenia/usuario/(:num)/editar', 'DuenaController::editarUsuario/$1', ['filter' => 'auth']);
$routes->get('duenia/usuario/(:num)/toggle', 'DuenaController::toggleEstado/$1', ['filter' => 'auth']);

// ERROR
$routes->get('error-sesion', 'ErrorController::index');

// CONTACTO
$routes->get('contacto', 'ContactoController::index');
$routes->post('contacto/enviar', 'ContactoController::enviar');
