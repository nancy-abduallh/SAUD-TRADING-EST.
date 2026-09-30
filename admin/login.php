<?php
session_start();

// Redirect to dashboard if already logged in
if (isset($_SESSION['admin_id'])) {
    header("Location: index.php");
    exit;
}

// Database connection via config
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'saud_trading_db');

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($conn->connect_error) {
    die("Database connection failed.");
}
$conn->set_charset('utf8mb4');

$error = '';

// Generate CSRF token if not exists
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Handle login submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate CSRF token
    if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        $error = "Invalid CSRF token.";
    } else {
        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';
        
        if (empty($username) || empty($password)) {
            $error = "Please enter both username and password.";
        } else {
            $stmt = $conn->prepare("SELECT * FROM admins WHERE username = ? LIMIT 1");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();
            $admin = $result->fetch_assoc();
            
            if ($admin && password_verify($password, $admin['password'])) {
                // Login success
                $_SESSION['admin_id'] = $admin['id'];
                $_SESSION['admin_name'] = $admin['full_name'] ?? $admin['username'];
                
                // Log activity
                $adminId = $admin['id'];
                $ip = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
                $logStmt = $conn->prepare("INSERT INTO activity_log (admin_id, action, details, ip_address) VALUES (?, 'login', 'Admin logged in', ?)");
                $logStmt->bind_param("is", $adminId, $ip);
                $logStmt->execute();
                
                // Regenerate session ID for security
                session_regenerate_id(true);
                
                header("Location: index.php");
                exit;
            } else {
                $error = "Invalid username or password.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SAUD Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="assets/css/dashboard.css">
    <style>
        .login-page {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(-45deg, #0a0e27, #12152a, #1a1f3e, #0d112b);
            background-size: 400% 400%;
            animation: gradientBG 15s ease infinite;
            font-family: 'Inter', sans-serif;
            color: #fff;
        }

        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .login-card {
            background: rgba(26, 31, 62, 0.6);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            padding: 40px;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }

        .login-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .login-logo {
            font-size: 28px;
            font-weight: 700;
            background: linear-gradient(135deg, #4fc3f7, #00e5ff, #7c4dff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 8px;
            display: block;
        }

        .login-subtitle {
            font-size: 14px;
            color: #94a3b8;
            font-weight: 400;
        }

        .form-group {
            margin-bottom: 20px;
            position: relative;
        }

        .form-group i.input-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 16px;
        }

        .form-control {
            width: 100%;
            padding: 14px 16px 14px 45px;
            background: rgba(10, 14, 39, 0.5);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            color: #fff;
            font-size: 15px;
            transition: all 0.3s ease;
            box-sizing: border-box;
        }

        .form-control:focus {
            outline: none;
            border-color: #4fc3f7;
            box-shadow: 0 0 0 3px rgba(79, 195, 247, 0.15);
        }

        .toggle-password {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            cursor: pointer;
            transition: color 0.3s ease;
        }

        .toggle-password:hover {
            color: #fff;
        }

        .form-options {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 25px;
            font-size: 14px;
        }

        .checkbox-label {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #cbd5e1;
            cursor: pointer;
        }

        .checkbox-label input[type="checkbox"] {
            accent-color: #4fc3f7;
            width: 16px;
            height: 16px;
        }

        .login-btn {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #4fc3f7, #00e5ff);
            border: none;
            border-radius: 8px;
            color: #0a0e27;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 229, 255, 0.3);
        }

        .alert-error {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.2);
            color: #ef4444;
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 10px;
            animation: shake 0.5s ease-in-out;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            20%, 60% { transform: translateX(-5px); }
            40%, 80% { transform: translateX(5px); }
        }
    </style>
</head>
<body class="login-page">

    <div class="login-card">
        <div class="login-header">
            <span class="login-logo">SAUD Trading Admin</span>
            <span class="login-subtitle">Enterprise Management Dashboard</span>
        </div>

        <?php if (!empty($error)): ?>
        <div class="alert-error">
            <i class="fa-solid fa-circle-exclamation"></i>
            <span><?= htmlspecialchars($error) ?></span>
        </div>
        <?php endif; ?>

        <form action="login.php" method="POST">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
            
            <div class="form-group">
                <i class="fa-solid fa-user input-icon"></i>
                <input type="text" name="username" class="form-control" placeholder="Username" required autofocus>
            </div>

            <div class="form-group">
                <i class="fa-solid fa-lock input-icon"></i>
                <input type="password" name="password" id="passwordInput" class="form-control" placeholder="Password" required>
                <i class="fa-solid fa-eye toggle-password" id="togglePassword"></i>
            </div>

            <div class="form-options">
                <label class="checkbox-label">
                    <input type="checkbox" name="remember">
                    <span>Remember me</span>
                </label>
            </div>

            <button type="submit" class="login-btn">
                <i class="fa-solid fa-right-to-bracket" style="margin-right: 8px;"></i> Login
            </button>
        </form>
    </div>

    <script>
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('passwordInput');
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });
    </script>
</body>
</html>
