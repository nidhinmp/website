<?php
/**
 * Database Configuration
 * National College Website
 */

define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'college_admin');
define('DB_PASSWORD', 'college_pass123');
define('DB_NAME', 'national_college');

try {
    $pdo = new PDO("mysql:host=" . DB_SERVER . ";dbname=" . DB_NAME, DB_USERNAME, DB_PASSWORD);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    die("ERROR: Could not connect. " . $e->getMessage());
}

// Start session
session_start();

// Site configuration
define('SITE_NAME', 'National College, Nadakakvu');
define('SITE_TAGLINE', 'Empowering Future Leaders');
define('SITE_EMAIL', 'info@nationalcollege.edu');
define('SITE_PHONE', '+91 9876543210');
define('SITE_ADDRESS', 'Nadakakvu, Kerala, India');
define('WHATSAPP_NUMBER', '+919876543210');