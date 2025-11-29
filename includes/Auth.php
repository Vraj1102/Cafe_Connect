<?php
class Auth {
    private $mysqli;
    private $max_attempts = 5;
    private $lockout_time = 900; // 15 minutes
    
    public function __construct($mysqli) {
        $this->mysqli = $mysqli;
    }
    
    // Check login attempts for brute force protection (session-based)
    private function checkLoginAttempts($username, $ip) {
        if (!isset($_SESSION['login_attempts'])) {
            $_SESSION['login_attempts'] = [];
        }
        $key = $username . '_' . $ip;
        if (isset($_SESSION['login_attempts'][$key])) {
            $attempts = $_SESSION['login_attempts'][$key];
            if ($attempts['count'] >= $this->max_attempts && (time() - $attempts['time']) < $this->lockout_time) {
                return false;
            }
        }
        return true;
    }
    
    // Log login attempt
    private function logAttempt($username, $ip) {
        $key = $username . '_' . $ip;
        if (!isset($_SESSION['login_attempts'][$key])) {
            $_SESSION['login_attempts'][$key] = ['count' => 0, 'time' => time()];
        }
        $_SESSION['login_attempts'][$key]['count']++;
        $_SESSION['login_attempts'][$key]['time'] = time();
    }
    
    // Clear login attempts on successful login
    private function clearAttempts($username, $ip) {
        $key = $username . '_' . $ip;
        if (isset($_SESSION['login_attempts'][$key])) {
            unset($_SESSION['login_attempts'][$key]);
        }
    }
    
    // Authenticate user
    public function authenticate($username, $password, $role = null) {
        $ip = $_SERVER['REMOTE_ADDR'];
        
        // Check brute force (optional - can be disabled)
        // if (!$this->checkLoginAttempts($username, $ip)) {
        //     return ['success' => false, 'message' => 'Too many failed attempts. Try again in 15 minutes.'];
        // }
        
        $user = null;
        
        // Try customer login
        if (!$role || $role === 'customer') {
            $stmt = $this->mysqli->prepare("SELECT c_id as id, c_username, c_pwd, c_firstname, c_lastname, c_type, 'customer' as role 
                FROM customer WHERE c_username = ? LIMIT 1");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $user = $result->fetch_assoc();
                // Check if admin
                if ($user['c_type'] === 'ADM') {
                    $user['role'] = 'admin';
                }
            }
        }
        
        // Try shop login
        if (!$user && (!$role || $role === 'shop')) {
            $stmt = $this->mysqli->prepare("SELECT s_id as id, s_username, s_pwd, s_name, 'shop' as role 
                FROM shop WHERE s_username = ? LIMIT 1");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $user = $result->fetch_assoc();
            }
        }
        
        // Verify password
        if ($user && $user['s_pwd'] === $password || $user && $user['c_pwd'] === $password) {
            $this->clearAttempts($username, $ip);
            $this->createSession($user);
            return ['success' => true, 'role' => $user['role'], 'user' => $user];
        }
        
        $this->logAttempt($username, $ip);
        return ['success' => false, 'message' => 'Invalid username or password'];
    }
    
    // Create secure session
    private function createSession($user) {
        session_regenerate_id(true);
        
        if ($user['role'] === 'customer') {
            $_SESSION['cid'] = $user['id'];
            $_SESSION['firstname'] = $user['c_firstname'];
            $_SESSION['lastname'] = $user['c_lastname'];
            $_SESSION['utype'] = 'customer';
        } elseif ($user['role'] === 'shop') {
            $_SESSION['sid'] = $user['id'];
            $_SESSION['username'] = $user['s_username'];
            $_SESSION['shopname'] = $user['s_name'];
            $_SESSION['utype'] = 'shopowner';
        } elseif ($user['role'] === 'admin') {
            $_SESSION['aid'] = $user['id'];
            $_SESSION['firstname'] = $user['c_firstname'];
            $_SESSION['lastname'] = $user['c_lastname'];
            $_SESSION['utype'] = 'ADMIN';
        }
        
        $_SESSION['role'] = $user['role'];
        $_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
        $_SESSION['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
        $_SESSION['last_activity'] = time();
    }
    
    // Check if user is authenticated
    public static function isAuthenticated() {
        return isset($_SESSION['role']) && isset($_SESSION['utype']);
    }
    
    // Get current user role
    public static function getRole() {
        return $_SESSION['role'] ?? null;
    }
    
    // Check if user has specific role
    public static function hasRole($role) {
        return self::getRole() === $role;
    }
    
    // Validate session
    public static function validateSession() {
        if (!self::isAuthenticated()) return false;
        
        // Check IP and user agent
        if ($_SESSION['ip'] !== $_SERVER['REMOTE_ADDR']) {
            self::logout();
            return false;
        }
        
        // Check session timeout (30 minutes)
        if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 1800)) {
            self::logout();
            return false;
        }
        
        $_SESSION['last_activity'] = time();
        return true;
    }
    
    // Logout
    public static function logout() {
        session_unset();
        session_destroy();
    }
    
    // Generate CSRF token
    public static function generateCSRFToken() {
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }
    
    // Verify CSRF token
    public static function verifyCSRFToken($token) {
        return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
    }
}
