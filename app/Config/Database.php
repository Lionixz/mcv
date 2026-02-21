<?php
namespace App\Config;

use mysqli;
class Database
{
    private static $connection = null;
    
    public static function getConnection()
    {
        if (self::$connection === null) {
            $host = $_ENV['DB_HOST'] ?? 'localhost';
            $dbname = $_ENV['DB_NAME'] ?? 'mvc';
            $username = $_ENV['DB_USERNAME'] ?? 'root';
            $password = $_ENV['DB_PASSWORD'] ?? '';
            
            self::$connection = new mysqli($host, $username, $password, $dbname);
            
            if (self::$connection->connect_error) {
                die("Database connection failed: " . self::$connection->connect_error);
            }
            
            // Set charset to utf8mb4
            self::$connection->set_charset('utf8mb4');
        }
        
        return self::$connection;
    }
}