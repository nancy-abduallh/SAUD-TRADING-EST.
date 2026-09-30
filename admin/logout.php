<?php
require_once __DIR__ . '/config.php';
if (!empty($_SESSION['admin_id']) && hash_equals(csrf_token(), (string)($_GET['t'] ?? ''))) {
    log_activity('Logged out');
    $_SESSION = [];
    session_destroy();
}
header('Location: login.php');
exit;