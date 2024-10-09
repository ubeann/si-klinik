<?php

use App\Controllers\AuthController;
use App\Controllers\HomeController;
use App\Controllers\PatientController;
use App\Controllers\ResumeController;
use App\Controllers\UserController;
use App\Router;

// Start the session
session_start();

// Autoloader function
spl_autoload_register(function ($class) {
    $prefix = 'App\\';
    $base_dir = __DIR__ . '/../app/';
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }
    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';
    if (file_exists($file)) {
        require $file;
    }
});

$router = new Router();

// Auth routes
$router->addRoute('/', HomeController::class, 'index');
$router->addRoute('/login', AuthController::class, 'login');
$router->addRoute('/register', AuthController::class, 'register');
$router->addRoute('/logout', AuthController::class, 'logout');
$router->addRoute('/dashboard', HomeController::class, 'dashboard');

// Patients routes
$router->addRoute('/patients', PatientController::class, 'index');
$router->addRoute('/patients/form-register', PatientController::class, 'registerForm');
$router->addRoute('/patients/register', PatientController::class, 'register');
$router->addRoute('/patients/form-edit', PatientController::class, 'editForm');
$router->addRoute('/patients/edit', PatientController::class, 'edit');
$router->addRoute('/patients/delete', PatientController::class, 'delete');

// Resume routes
$router->addRoute('/resume', ResumeController::class, 'index');
$router->addRoute('/resume/form', ResumeController::class, 'form');
$router->addRoute('/resume/save', ResumeController::class, 'save');

// Users routes
$router->addRoute('/users', UserController::class, 'index');
$router->addRoute('/users/form-register', UserController::class, 'registerForm');
$router->addRoute('/users/register', UserController::class, 'register');
$router->addRoute('/users/form-edit', UserController::class, 'editForm');
$router->addRoute('/users/edit', UserController::class, 'edit');
$router->addRoute('/users/change-password', UserController::class, 'changePassword');
$router->addRoute('/users/delete', UserController::class, 'delete');

// Get the current URL
$url = $_SERVER['REQUEST_URI'];

// Dispatch the route
$router->dispatch($url);
