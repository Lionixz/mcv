<?php
namespace App\Models;

use App\Config\Database;

class User
{
    private $conn;
    private $table = 'users';
    
    public function __construct()
    {
        $this->conn = Database::getConnection();
    }
    
    /**
     * Find user by Google ID
     */
    public function findByGoogleId($googleId)
    {
        $stmt = $this->conn->prepare("SELECT id, google_id, name, email, picture, role, session_token FROM users WHERE google_id = ?");
        $stmt->bind_param("s", $googleId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        }
        
        return null;
    }
    
    /**
     * Create new user
     */
    public function create($userData)
    {
        $stmt = $this->conn->prepare(
            "INSERT INTO users (google_id, name, email, picture, role, last_seen, created_at)
             VALUES (?, ?, ?, ?, ?, ?, NOW())"
        );
        
        $stmt->bind_param(
            "ssssss",
            $userData['google_id'],
            $userData['name'],
            $userData['email'],
            $userData['picture'],
            $userData['role'],
            $userData['last_seen']
        );
        
        if ($stmt->execute()) {
            return $this->conn->insert_id;
        }
        
        return null;
    }
    
    /**
     * Update user's last seen timestamp
     */
    public function updateLastSeen($googleId, $lastSeen)
    {
        $stmt = $this->conn->prepare("UPDATE users SET last_seen = ? WHERE google_id = ?");
        $stmt->bind_param("ss", $lastSeen, $googleId);
        return $stmt->execute();
    }
    
    /**
     * Update session token
     */
    public function updateSessionToken($googleId, $token)
    {
        $stmt = $this->conn->prepare("UPDATE users SET session_token = ? WHERE google_id = ?");
        $stmt->bind_param("ss", $token, $googleId);
        return $stmt->execute();
    }
    
    /**
     * Validate session token
     */
    public function validateSession($googleId, $sessionToken)
    {
        $stmt = $this->conn->prepare("SELECT session_token, role FROM users WHERE google_id = ?");
        $stmt->bind_param("s", $googleId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($row = $result->fetch_assoc()) {
            return [
                'valid' => $row['session_token'] === $sessionToken,
                'role' => $row['role']
            ];
        }
        
        return ['valid' => false, 'role' => null];
    }
    
    /**
     * Logout user (clear session token)
     */
    public function logout($googleId)
    {
        $stmt = $this->conn->prepare("UPDATE users SET last_seen = NOW(), session_token = NULL WHERE google_id = ?");
        $stmt->bind_param("s", $googleId);
        return $stmt->execute();
    }
    
    /**
     * Get user role
     */
    public function getRole($googleId)
    {
        $stmt = $this->conn->prepare("SELECT role FROM users WHERE google_id = ?");
        $stmt->bind_param("s", $googleId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($row = $result->fetch_assoc()) {
            return $row['role'];
        }
        
        return null;
    }
}