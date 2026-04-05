<?php
/**
 * Database Setup Script
 * Run this file once to set up the database
 */

require_once 'config.php';

try {
    // Create admin table
    $pdo->exec("CREATE TABLE IF NOT EXISTS admin (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) UNIQUE NOT NULL,
        password VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");
    
    // Create courses table
    $pdo->exec("CREATE TABLE IF NOT EXISTS courses (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(200) NOT NULL,
        duration VARCHAR(100),
        eligibility VARCHAR(200),
        description TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");
    
    // Create staff table
    $pdo->exec("CREATE TABLE IF NOT EXISTS staff (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        designation VARCHAR(100),
        department VARCHAR(100),
        image VARCHAR(255),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");
    
    // Create gallery table
    $pdo->exec("CREATE TABLE IF NOT EXISTS gallery (
        id INT AUTO_INCREMENT PRIMARY KEY,
        image_path VARCHAR(255) NOT NULL,
        category VARCHAR(50) DEFAULT 'college',
        uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");
    
    // Create enquiries table
    $pdo->exec("CREATE TABLE IF NOT EXISTS enquiries (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        email VARCHAR(100) NOT NULL,
        phone VARCHAR(20),
        message TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");
    
    // Insert default admin (username: admin, password: admin123)
    $adminPassword = password_hash('admin123', PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("INSERT IGNORE INTO admin (username, password) VALUES (?, ?)");
    $stmt->execute(['admin', $adminPassword]);
    
    // Insert sample courses
    $courses = [
        ['Bachelor of Arts (BA)', '3 Years', '10+2 Pass', 'Comprehensive undergraduate program in Arts with multiple specializations including History, Economics, Political Science, and Sociology.'],
        ['Bachelor of Science (BSc)', '3 Years', '10+2 Pass (Science)', 'Undergraduate program in Science with specializations in Physics, Chemistry, Mathematics, and Biology.'],
        ['Bachelor of Commerce (BCom)', '3 Years', '10+2 Pass', 'Professional accounting and commerce program preparing students for careers in finance and business.'],
        ['Bachelor of Computer Applications (BCA)', '3 Years', '10+2 Pass', 'Computer science and applications program focusing on programming, web development, and software engineering.'],
        ['Master of Arts (MA)', '2 Years', 'BA Pass', 'Advanced postgraduate program in Arts with research opportunities in various specializations.'],
        ['Master of Science (MSc)', '2 Years', 'BSc Pass', 'Advanced scientific research program with modern laboratory facilities and expert faculty.']
    ];
    
    $stmt = $pdo->prepare("INSERT IGNORE INTO courses (name, duration, eligibility, description) VALUES (?, ?, ?, ?)");
    foreach ($courses as $course) {
        $stmt->execute($course);
    }
    
    // Insert sample staff
    $staff = [
        ['Dr. Rajesh Kumar', 'Principal', 'Administration', ''],
        ['Prof. Sarah Johnson', 'Head of Department', 'Department of Arts', ''],
        ['Dr. Michael Chen', 'Assistant Professor', 'Department of Science', ''],
        ['Ms. Priya Nair', 'Senior Lecturer', 'Department of Commerce', ''],
        ['Mr. Anoop Raj', 'Lecturer', 'Department of Computer Applications', ''],
        ['Dr. Lisa Mathew', 'Assistant Professor', 'Department of Science', '']
    ];
    
    $stmt = $pdo->prepare("INSERT IGNORE INTO staff (name, designation, department, image) VALUES (?, ?, ?, ?)");
    foreach ($staff as $s) {
        $stmt->execute($s);
    }
    
    echo "Database setup completed successfully!<br>";
    echo "Default admin credentials:<br>";
    echo "Username: admin<br>";
    echo "Password: admin123<br>";
    
} catch(PDOException $e) {
    echo "ERROR: " . $e->getMessage();
}
?>