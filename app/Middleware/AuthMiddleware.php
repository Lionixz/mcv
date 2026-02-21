<?php
namespace App\Middleware;

use App\Models\User;

class AuthMiddleware
{
    /**
     * Check if user is authenticated
     */
    public static function check()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        // Check if all required session variables exist
        if (!isset($_SESSION['user_id'], $_SESSION['user_name'], 
                  $_SESSION['user_email'], $_SESSION['user_picture'], 
                  $_SESSION['session_token'], $_SESSION['role'])) {
            self::redirectToLogin();
        }
        
        $userModel = new User();
        $validation = $userModel->validateSession(
            $_SESSION['user_id'], 
            $_SESSION['session_token']
        );
        
        if (!$validation['valid']) {
            self::destroySession();
            self::redirectToLogin();
        }
        
        return true;
    }
    
    /**
     * Check if user is authenticated and redirect if not
     */
    public static function requireAuth()
    {
        try {
            return self::check();
        } catch (\Exception $e) {
            self::redirectToLogin();
        }
    }
    
    /**
     * Redirect to login page
     */
    private static function redirectToLogin()
    {
        header('Location: /mvc/');
        exit;
    }
    
    /**
     * Destroy session
     */
    private static function destroySession()
    {
        $_SESSION = array();
        
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        
        session_destroy();
    }
}