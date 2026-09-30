<?php
require_once __DIR__ . '/config.php';
require_login(defined('IS_API'));

$ADMIN = row('SELECT id, username, email FROM admins WHERE id = ?', [(int)$_SESSION['admin_id']]);
if (!$ADMIN) {
    $_SESSION = [];
    if (defined('IS_API')) json_out(['ok' => false, 'error' => 'Session expired'], 401);
    header('Location: login.php');
    exit;
}