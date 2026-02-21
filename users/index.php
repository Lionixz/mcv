<?php
require_once __DIR__ . '/../vendor/autoload.php';

use App\Config\Config;
use App\Middleware\RoleMiddleware;

// Load environment
Config::load();

// Start session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if user is authenticated and has user role
try {
    RoleMiddleware::requireUser();
} catch (Exception $e) {
    // Redirect to login if not authorized
    header('Location: ' . Config::getAppUrl() . '/');
    exit;
}

// Include the actual user dashboard
require_once 'dashboard.php';