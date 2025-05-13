<?php

namespace Controllers; 
use AuthController;
use Exception;
require_once 'securityController/config.php';
require_once 'AuthController.php'; 
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Middleware
{
    private static $jwtSecret = JWTSECRETKEY; // Must match AuthController secret

    public static function authenticate()
    {
        // Check for access token cookie
        if (isset($_COOKIE['access_token'])) {
            try {
                $decoded = JWT::decode($_COOKIE['access_token'], new Key(self::$jwtSecret, 'HS256'));
                return (array)$decoded;
            } catch (Exception $e) {
                error_log("JWT decode error: " . $e->getMessage());
            }
        }

        // Attempt token refresh
        $auth = new AuthController();
        $refreshResult = $auth->refreshToken();
        
        if ($refreshResult['success'] ?? false) {
            // Set new access token cookie, if refresh token is success
            setcookie('access_token', $refreshResult['access_token'], [
                'expires' => time() + ($refreshResult['expires_in'] ?? 60),
                'path' => '/',
                'httponly' => true,
                'secure' => true,
                'samesite' => 'Strict'
            ]);
            return (array)JWT::decode($refreshResult['access_token'], new Key(self::$jwtSecret, 'HS256'));
        }

        //  If no valid token exists and token refresh failed
        header("Location: ../Auth/login.php");
        exit();
    }

    public static function authorize($roles = [])
    {
        $user = self::authenticate();  // Calls it to get the user’s data 
        
        if (!empty($roles) && !in_array($user['role'], $roles)) {
            http_response_code(403); // Forbidden
        die("Access Denied: Your role is ({$user['role']}), so you don't have permission");
        }
        
        return $user;
    }
}

// Middleware is a design pattern used in software development. It acts as a layer between the user request and the final response. before the request is passed on to the main application logic (controllers) or before the response is sent back to the user.