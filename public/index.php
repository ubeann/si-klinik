<?php

use App\Controllers\AuthController;
use App\Controllers\HomeController;
use App\Controllers\PatientController;
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

// Define your routes
$router->addRoute('/', HomeController::class, 'index');
$router->addRoute('/login', AuthController::class, 'login');
$router->addRoute('/register', AuthController::class, 'register');
$router->addRoute('/logout', AuthController::class, 'logout');
$router->addRoute('/dashboard', HomeController::class, 'dashboard');
$router->addRoute('/patients', PatientController::class, 'index');
$router->addRoute('/patients/form-register', PatientController::class, 'registerForm');
$router->addRoute('/patients/register', PatientController::class, 'register');
$router->addRoute('/patients/delete', PatientController::class, 'delete');

// Get the current URL
$url = $_SERVER['REQUEST_URI'];

// Dispatch the route
$router->dispatch($url);
