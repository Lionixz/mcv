<?php
namespace App\Controllers;

use App\Config\Config;
use App\Models\User;
use Google_Service_Oauth2;

class AuthController
{
    private $userModel;
    
    public function __construct()
    {
        $this->userModel = new User();
        
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }
    
    /**
     * Handle Google OAuth callback
     */
    public function callback()
    {
        $client = Config::getGoogleClient();
        
        // Check if error returned from Google
        if (isset($_GET['error'])) {
            $this->handleError($_GET['error']);
            return;
        }
        
        // Verify CSRF state
        if (!isset($_GET['state']) || !isset($_SESSION['google_auth_state']) || 
            $_SESSION['google_auth_state'] !== $_GET['state']) {
            $this->handleError('Invalid state parameter');
            return;
        }
        
        // Check if authorization code exists
        if (!isset($_GET['code'])) {
            $this->handleError('No authorization code provided');
            return;
        }
        
        try {
            // Exchange authorization code for access token
            $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
            
            if (isset($token['error'])) {
                throw new \Exception($token['error']);
            }
            
            // Set access token
            $client->setAccessToken($token['access_token']);
            $_SESSION['access_token'] = $token['access_token'];
            
            // Get user info from Google
            $oauth = new Google_Service_Oauth2($client);
            $userInfo = $oauth->userinfo->get();
            
            // Store user info in session
            $_SESSION['user_id'] = $userInfo->id;
            $_SESSION['user_email'] = $userInfo->email;
            $_SESSION['user_name'] = $userInfo->name;
            $_SESSION['user_picture'] = $userInfo->picture;
            
            $now = date('Y-m-d H:i:s');
            
            // Check if user exists in database
            $existingUser = $this->userModel->findByGoogleId($userInfo->id);
            
            if (!$existingUser) {
                // New user - assign default role
                $role = 'user'; // Default role for new users
                
                $userData = [
                    'google_id' => $userInfo->id,
                    'name' => $userInfo->name,
                    'email' => $userInfo->email,
                    'picture' => $userInfo->picture,
                    'role' => $role,
                    'last_seen' => $now
                ];
                
                $userId = $this->userModel->create($userData);
                $_SESSION['role'] = $role;
                
                error_log("New user created: {$userInfo->email} with role: {$role}");
            } else {
                // Existing user - update last seen and get role
                $this->userModel->updateLastSeen($userInfo->id, $now);
                $_SESSION['role'] = $existingUser['role'];
                
                error_log("Existing user logged in: {$userInfo->email} with role: {$existingUser['role']}");
            }
            
            // Generate and store session token
            $sessionToken = bin2hex(random_bytes(32));
            $this->userModel->updateSessionToken($userInfo->id, $sessionToken);
            $_SESSION['session_token'] = $sessionToken;
            
            // Clear CSRF state
            unset($_SESSION['google_auth_state']);
            
            // Redirect based on role
            $this->redirectBasedOnRole($_SESSION['role']);
            
        } catch (\Exception $e) {
            error_log("Google Auth Error: " . $e->getMessage());
            $this->handleError('Authentication failed: ' . $e->getMessage());
        }
    }
    
    /**
     * Handle logout
     */
    public function logout()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        // Update database if user is logged in
        if (isset($_SESSION['user_id'])) {
            $this->userModel->logout($_SESSION['user_id']);
        }
        
        // Clear all session data
        $_SESSION = array();
        
        // Destroy the session cookie
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        
        // Destroy session
        session_destroy();
        
        // Redirect to home page
        header('Location: ' . Config::getAppUrl() . '/');
        exit;
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
    
    /**
     * Handle authentication errors
     */
    private function handleError($error)
    {
        error_log("Auth error: " . $error);
        
        // Clear any partial session data
        if (session_status() == PHP_SESSION_ACTIVE) {
            session_destroy();
        }
        
        // Redirect to home page with error
        header('Location: ' . Config::getAppUrl() . '/?error=' . urlencode($error));
        exit;
    }
}