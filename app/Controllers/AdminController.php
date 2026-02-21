<?php
namespace App\Controllers;

use App\Middleware\RoleMiddleware;

class AdminController
{
    public function __construct()
    {
        // Ensure only admins can access this controller
        RoleMiddleware::requireAdmin();
    }
    
    /**
     * This method won't be called directly as we're using separate admin files
     * It's kept for API endpoints if needed
     */
    public function index()
    {
        // This would be for API endpoints
        header('Content-Type: application/json');
        echo json_encode(['message' => 'Admin API']);
        exit;
    }
}