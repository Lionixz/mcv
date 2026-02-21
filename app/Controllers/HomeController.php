<?php
namespace App\Controllers;

use App\Config\Config;

class HomeController
{
    /**
     * Display login page
     */
    public function index()
    {
        // If user is already logged in, redirect to appropriate dashboard
        if (isset($_SESSION['user_id']) && isset($_SESSION['role'])) {
            $this->redirectBasedOnRole($_SESSION['role']);
            return;
        }
        
        $client = Config::getGoogleClient();
        
        // CSRF protection
        $state = bin2hex(random_bytes(16));
        $_SESSION['google_auth_state'] = $state;
        $client->setState($state);
        
        $loginUrl = $client->createAuthUrl();
        
        // Load the login view
        require_once __DIR__ . '/../Views/auth/login.php';
    }
    
    /**
     * Redirect user based on role
     */
    private function redirectBasedOnRole($role)
    {
        $baseUrl = Config::getAppUrl();
        
        if ($role === 'admin') {
            header("Location: {$baseUrl}/admin/index.php");
        } else {
            header("Location: {$baseUrl}/users/index.php");
        }
        exit;
    }
}