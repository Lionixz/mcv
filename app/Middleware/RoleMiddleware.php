<?php
namespace App\Middleware;

class RoleMiddleware
{
    /**
     * Check if user has required role
     */
    public static function requireRole($requiredRole)
    {
        AuthMiddleware::requireAuth();
        
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== $requiredRole) {
            self::redirectToDashboard();
        }
        
        return true;
    }
    
    /**
     * Check if user is admin
     */
    public static function requireAdmin()
    {
        return self::requireRole('admin');
    }
    
    /**
     * Check if user is regular user
     */
    public static function requireUser()
    {
        return self::requireRole('user');
    }
    
    /**
     * Redirect to appropriate dashboard based on role
     */
    private static function redirectToDashboard()
    {
        $role = $_SESSION['role'] ?? null;
        
        if ($role === 'admin') {
            header('Location: /mvc/admin/index.php');
        } elseif ($role === 'user') {
            header('Location: /mvc/users/index.php');
        } else {
            header('Location: /mvc/');
        }
        exit;
    }
}