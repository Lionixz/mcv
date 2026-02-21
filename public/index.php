<?php
require_once __DIR__ . '/../vendor/autoload.php';

use App\Config\Config;

// Load environment variables
Config::load();

// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Simple routing
$url = isset($_GET['url']) ? rtrim($_GET['url'], '/') : '';
$urlParts = explode('/', $url);

// Default controller and method
$controllerName = !empty($urlParts[0]) ? ucfirst($urlParts[0]) . 'Controller' : 'HomeController';
$methodName = !empty($urlParts[1]) ? $urlParts[1] : 'index';
$params = array_slice($urlParts, 2);

// Special route for Google callback
if ($controllerName === 'AuthController' && $methodName === 'google') {
    $methodName = 'callback';
}

// Controller namespace
$controllerClass = "App\\Controllers\\{$controllerName}";

if (class_exists($controllerClass)) {
    $controller = new $controllerClass();
    
    if (method_exists($controller, $methodName)) {
        call_user_func_array([$controller, $methodName], $params);
    } else {
        // Method not found
        header("HTTP/1.0 404 Not Found");
        include __DIR__ . '/../app/Views/errors/404.php';
    }
} else {
    // Controller not found
    header("HTTP/1.0 404 Not Found");
    include __DIR__ . '/../app/Views/errors/404.php';
}