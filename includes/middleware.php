<?php
// Access Control Middleware

require_once __DIR__ . '/Auth.php';

class Middleware {
    // Require authentication
    public static function requireAuth() {
        if (!Auth::validateSession()) {
            header("Location: /CafeConnect/auth_login.php");
            exit();
        }
    }
    
    // Require specific role
    public static function requireRole($role) {
        self::requireAuth();
        
        if (!Auth::hasRole($role)) {
            header("Location: /CafeConnect/includes/restricted.php");
            exit();
        }
    }
    
    // Require customer role
    public static function requireCustomer() {
        self::requireRole('customer');
    }
    
    // Require shop owner role
    public static function requireShop() {
        self::requireRole('shop');
    }
    
    // Require admin role
    public static function requireAdmin() {
        self::requireRole('admin');
    }
    
    // Check if user can access resource
    public static function canAccess($requiredRole) {
        if (!Auth::isAuthenticated()) {
            return false;
        }
        
        $userRole = Auth::getRole();
        
        // Admin can access everything
        if ($userRole === 'admin') {
            return true;
        }
        
        return $userRole === $requiredRole;
    }
}
