<?php
 
use CodeIgniter\Router\RouteCollection;
 
/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
 
$routes->group('auth', function($routes)
{
    $routes->get('login',    'Auth::loginForm',    ['as' => 'loginForm']);
    $routes->get('register', 'Auth::registerForm', ['as' => 'registerForm']);
    $routes->get('forget',   'Auth::forget',       ['as' => 'forgetForm']);
 
    $routes->post('login',    'Auth::loginProcess',    ['as' => 'loginProcess']);
    $routes->post('register', 'Auth::registerProcess', ['as' => 'registerProcess']);
});
 
// Admin (nivel 1)
$routes->group('admin', ['filter' => 'role'], function($routes)
{
    $routes->get('dashboard', 'Admin::index', ['as' => 'adminDashboard']);
    $routes->post('createEnrollment','Admin::createEnrollment', ['as' => 'adminCreateEnrollment']);
    $routes->post('deleteEnrollment','Admin::deleteEnrollment', ['as' => 'adminDeleteEnrollment']); 
     $routes->post('getUser',          'Admin::getUser',          ['as' => 'adminGetUser']);
    $routes->post('updateUser',       'Admin::updateUser',       ['as' => 'adminUpdateUser']);
    $routes->post('deleteUser',       'Admin::deleteUser',       ['as' => 'adminDeleteUser']);
});
 
// Profesor (nivel 2)
$routes->group('teacher', ['filter' => 'role'], function($routes)
{
    $routes->get('dashboard', 'Teacher::index', ['as' => 'teacherDashboard']);
    $routes->post('sendMessage', 'Teacher::sendMessage', ['as' => 'teacherSendMessage']);
});
 
// Alumno (nivel 3)
$routes->group('student', ['filter' => 'role'], function($routes)
{
    $routes->get('dashboard', 'Student::index', ['as' => 'studentDashboard']);
});
 
$routes->group('services', function($routes)
{
    $routes->get('geolocation',  'Api::geolocation', ['as' => 'apiGeolocationGet']);
    $routes->post('geolocation', 'Api::geolocation', ['as' => 'apiGeolocationPost']);
 
    $routes->get('telegram',  'Api::telegram', ['as' => 'apiTelegramGet']);
});
 
$routes->group('admin', function($routes)
{
    $routes->get('create',         'Levels::create',    ['as' => 'createLevel']);
    $routes->get('read',           'Levels::read',      ['as' => 'readLevel']);
    $routes->get('delete/(:num)',  'Levels::delete/$1', ['as' => 'deleteLevel']);
    $routes->get('update/(:num)',  'Levels::update/$1', ['as' => 'updateLevel']);
 
    $routes->post('apiCreate',      'Levels::apiCreate', ['as' => 'apiCreate']);
    $routes->post('apiDelete',      'Levels::apiDelete', ['as' => 'apiDelete']);
});