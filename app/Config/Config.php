<?php
namespace App\Config;

use Dotenv\Dotenv;
use Google_Client;

class Config
{
    private static $googleClient = null;
    
    public static function load()
    {
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../..');
        $dotenv->load();
    }
    
    public static function getGoogleClient()
    {
        if (self::$googleClient === null) {
            self::$googleClient = new Google_Client();
            self::$googleClient->setClientId($_ENV['GOOGLE_CLIENT_ID']);
            self::$googleClient->setClientSecret($_ENV['GOOGLE_CLIENT_SECRET']);
            self::$googleClient->setRedirectUri($_ENV['GOOGLE_REDIRECT_URI']);
            self::$googleClient->addScope('email');
            self::$googleClient->addScope('profile');
            self::$googleClient->setPrompt('select_account');
            self::$googleClient->setAccessType('offline');
        }
        
        return self::$googleClient;
    }
    
    public static function getAppUrl()
    {
        return $_ENV['APP_URL'] ?? 'http://localhost/mvc';
    }
}