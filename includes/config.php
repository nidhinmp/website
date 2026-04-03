<?php
/**
 * Configuration File
 * National College, Nadakakvu
 */

// Database Configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'national_college');
define('DB_USER', 'root');
define('DB_PASS', '');

// Site Configuration
define('SITE_NAME', 'National College, Nadakakvu');
define('SITE_TAGLINE', 'Empowering Future Leaders Through Quality Education');
define('SITE_EMAIL', 'info@nationalcollege.edu');
define('SITE_PHONE', '+91 9876543210');
define('SITE_ADDRESS', 'Nadakakvu, Kerala, India');

// Admin Configuration
define('ADMIN_PATH', 'admin');

// Upload Paths
define('UPLOAD_PATH', 'uploads/');
define('STAFF_UPLOAD_PATH', 'uploads/staff/');
define('GALLERY_UPLOAD_PATH', 'uploads/gallery/');

// Initialize session
session_start();

// Database Connection
function getDB() {
    try {
        $pdo = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=utf8mb4", DB_USER, DB_PASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        return $pdo;
    } catch (PDOException $e) {
        die("Database connection failed: " . $e->getMessage());
    }
}

// Check if user is logged in as admin
function isAdmin() {
    return isset($_SESSION['admin_id']) && !empty($_SESSION['admin_id']);
}

// Redirect to login if not admin
function requireAdmin() {
    if (!isAdmin()) {
        header('Location: login.php');
        exit;
    }
}

// Sanitize input
function sanitize($input) {
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}

// Upload image and return path
function uploadImage($file, $path) {
    if ($file['error'] === UPLOAD_ERR_OK) {
        $tmp_name = $file['tmp_name'];
        $name = basename($file['name']);
        $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
        
        // Allowed extensions
        $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        
        if (in_array($ext, $allowed)) {
            $new_name = time() . '_' . uniqid() . '.' . $ext;
            $destination = $path . $new_name;
            
            if (move_uploaded_file($tmp_name, $destination)) {
                return $new_name;
            }
        }
    }
    return null;
}

// Delete image file
function deleteImage($path, $filename) {
    if ($filename && file_exists($path . $filename)) {
        unlink($path . $filename);
    }
}

// Format date
function formatDate($date) {
    return date('d M Y', strtotime($date));
}

// Get current page
function getCurrentPage() {
    return basename($_SERVER['PHP_SELF'], '.php');
}