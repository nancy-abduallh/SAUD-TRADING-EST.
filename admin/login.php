<?php
require_once __DIR__ . '/config.php';
ensure_default_admin();

if (!empty($_SESSION['admin_id'])) { header('Location: index.php'); exit; }

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (($_SESSION['lock_until'] ?? 0) > time()) {
        $error = 'Too many attempts. Please wait a minute.';
    } elseif (!hash_equals(csrf_token(), (string)($_POST['csrf'] ?? ''))) {
        $error = 'Session expired. Please reload the page.';
    } else {
        $u = trim((string)($_POST['username'] ?? ''));
        $p = (string)($_POST['password'] ?? '');
        $a = row('SELECT * FROM admins WHERE username = ?', [$u]);
        if ($a && password_verify($p, $a['password_hash'])) {
            session_regenerate_id(true);
            $_SESSION['admin_id'] = (int)$a['id'];
            $_SESSION['last'] = time();
            $_SESSION['fails'] = 0;
            unset($_SESSION['csrf']);
            log_activity('Logged in', $u);
            header('Location: index.php');
            exit;
        }
        $_SESSION['fails'] = ($_SESSION['fails'] ?? 0) + 1;
        if ($_SESSION['fails'] >= 5) { $_SESSION['lock_until'] = time() + 60; $_SESSION['fails'] = 0; }
        $error = 'Invalid username or password.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login · SAUD Admin</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/dashboard.css">
</head>
<body class="login-body">
  <div class="bg-orbs"><span></span><span></span><span></span></div>
  <main class="login-card glow">
    <div class="logo-mark big">S</div>
    <h1>SAUD TRADING EST.</h1>
    <p class="muted">Sign in to the admin dashboard</p>
    <?php if ($error): ?><div class="alert"><?= e($error) ?></div><?php endif; ?>
    <form method="post" id="loginForm" novalidate>
      <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
      <div class="field"><label for="u">Username</label>
        <input id="u" name="username" autocomplete="username" required autofocus></div>
      <div class="field"><label for="p">Password</label>
        <input id="p" name="password" type="password" autocomplete="current-password" required></div>
      <div class="alert" id="clientErr" hidden>Please enter your username and password.</div>
      <button class="btn btn-primary block" type="submit">Sign in</button>
    </form>
  </main>
  <script>
    document.getElementById('loginForm').addEventListener('submit', function (e) {
      if (!this.username.value.trim() || !this.password.value) {
        e.preventDefault();
        document.getElementById('clientErr').hidden = false;
      }
    });
  </script>
</body>
</html>