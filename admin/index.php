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

// Check if user is admin
try {
    RoleMiddleware::requireAdmin();
} catch (Exception $e) {
    // Redirect to login if not admin
    header('Location: ' . Config::getAppUrl() . '/');
    exit;
}

// Include the actual admin dashboard
require_once 'dashboard.php';