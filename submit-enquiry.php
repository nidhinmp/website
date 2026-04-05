<?php
/**
 * Submit Enquiry - AJAX handler
 */

header('Content-Type: application/json');
require_once 'config.php';

$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $message = trim($_POST['message'] ?? '');
    
    // Validate inputs
    if (empty($name) || empty($email) || empty($message)) {
        $response['message'] = 'Please fill in all required fields.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response['message'] = 'Please enter a valid email address.';
    } else {
        try {
            $stmt = $pdo->prepare("INSERT INTO enquiries (name, email, phone, message) VALUES (?, ?, ?, ?)");
            $stmt->execute([$name, $email, $phone, $message]);
            $response['success'] = true;
            $response['message'] = 'Thank you for your enquiry! We will contact you soon.';
        } catch (PDOException $e) {
            $response['message'] = 'Error submitting your enquiry. Please try again.';
        }
    }
} else {
    $response['message'] = 'Invalid request method.';
}

echo json_encode($response);
exit;