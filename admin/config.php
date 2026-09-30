<?php
session_start();

// Database config
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'saud_trading_db');

// Create connection
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}
$conn->set_charset('utf8mb4');

// CSRF token generation
function generateCsrfToken() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function validateCsrfToken($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

// Helper: check if admin is logged in
function isLoggedIn() {
    return isset($_SESSION['admin_id']);
}

// Helper: get current admin info
function getAdminInfo($conn) {
    if (!isLoggedIn()) return null;
    $id = (int)$_SESSION['admin_id'];
    $stmt = $conn->prepare("SELECT id, username, email, full_name, avatar FROM admins WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

// Helper: log activity
function logActivity($conn, $action, $details = '') {
    if (!isLoggedIn()) return;
    $admin_id = (int)$_SESSION['admin_id'];
    $ip = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
    $stmt = $conn->prepare("INSERT INTO activity_log (admin_id, action, details, ip_address) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $admin_id, $action, $details, $ip);
    $stmt->execute();
}

// Helper: sanitize input
function sanitize($data) {
    if (is_array($data)) {
        return array_map('sanitize', $data);
    }
    return htmlspecialchars(strip_tags(trim($data)), ENT_QUOTES, 'UTF-8');
}

// Helper: upload image
function uploadImage($file, $directory = '../uploads/') {
    if (!isset($file) || $file['error'] !== UPLOAD_ERR_OK) {
        return false;
    }

    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/svg+xml'];
    $maxSize = 5 * 1024 * 1024; // 5MB

    if (!in_array($file['type'], $allowedTypes)) {
        return ['success' => false, 'error' => 'Invalid file type. Only JPG, PNG, GIF, WEBP and SVG are allowed.'];
    }

    if ($file['size'] > $maxSize) {
        return ['success' => false, 'error' => 'File too large. Maximum size is 5MB.'];
    }

    if (!is_dir($directory)) {
        mkdir($directory, 0755, true);
    }

    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    if (empty($extension) && $file['type'] === 'image/svg+xml') {
        $extension = 'svg';
    }
    
    $filename = uniqid('img_', true) . '.' . $extension;
    $destination = rtrim($directory, '/') . '/' . $filename;

    if (move_uploaded_file($file['tmp_name'], $destination)) {
        return ['success' => true, 'filename' => $filename, 'path' => $destination];
    }

    return ['success' => false, 'error' => 'Failed to move uploaded file.'];
}

// Helper: format date
function formatDate($date, $format = 'Y-m-d H:i:s') {
    if (empty($date)) return '';
    return date($format, strtotime($date));
}

// Helper: get setting
function getSetting($conn, $key, $default = '') {
    $stmt = $conn->prepare("SELECT setting_value FROM site_settings WHERE setting_key = ?");
    $stmt->bind_param("s", $key);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        return $row['setting_value'];
    }
    return $default;
}

// Helper: get count
function getCount($conn, $table, $where = '') {
    $sql = "SELECT COUNT(*) as count FROM " . preg_replace('/[^a-zA-Z0-9_]/', '', $table);
    if (!empty($where)) {
        $sql .= " WHERE " . $where;
    }
    $result = $conn->query($sql);
    if ($result && $row = $result->fetch_assoc()) {
        return $row['count'];
    }
    return 0;
}
?>
