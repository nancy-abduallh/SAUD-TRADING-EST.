<?php
define('DB_HOST', '127.0.0.1');
define('DB_PORT', 3307);
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'saud_trading_db');
define('UPLOAD_PATH', __DIR__ . '/uploads/');
define('MAX_UPLOAD_BYTES', 5 * 1024 * 1024);
define('SESSION_TIMEOUT', 1800); // 30 min idle

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// public_api.php sets NO_SESSION so the public site never waits on a login session lock
if (!defined('NO_SESSION') && session_status() === PHP_SESSION_NONE) {
    session_name('saud_admin');
    session_set_cookie_params(['httponly' => true, 'samesite' => 'Lax']);
    session_start();
}

/* ---------- language & internationalization ---------- */
if (isset($_GET['lang'])) {
    $reqLang = strtolower(trim((string)$_GET['lang']));
    if (in_array($reqLang, ['ar', 'en'], true)) {
        if (session_status() === PHP_SESSION_ACTIVE) {
            $_SESSION['lang'] = $reqLang;
        }
        setcookie('admin_lang', $reqLang, time() + 86400 * 365, '/');
    }
}
function current_lang(): string {
    return $_SESSION['lang'] ?? $_COOKIE['admin_lang'] ?? 'ar';
}
function is_rtl(): bool {
    return current_lang() === 'ar';
}
function __(string $key, ?string $fallback = null): string {
    static $dict = null;
    if ($dict === null) {
        $dict = file_exists(__DIR__ . '/includes/lang.php') ? require __DIR__ . '/includes/lang.php' : [];
    }
    $lang = current_lang();
    return $dict[$lang][$key] ?? $dict['en'][$key] ?? $fallback ?? $key;
}

/* ---------- database helpers ---------- */
function db(): mysqli {
    static $c = null;
    if ($c === null) {
        try {
            $c = new mysqli(
                DB_HOST,
                DB_USER,
                DB_PASS,
                DB_NAME,
                DB_PORT
            );
            $c->set_charset('utf8mb4');
        } catch (Throwable $e) {
            http_response_code(500);
            exit('Database connection failed. Start MySQL in XAMPP and import setup_database.sql.');
        }
    }
    return $c;
}
function q(string $sql, array $p = []): mysqli_stmt {
    $st = db()->prepare($sql);
    if ($p) {
        $types = '';
        foreach ($p as $v) { $types .= is_int($v) ? 'i' : (is_float($v) ? 'd' : 's'); }
        $st->bind_param($types, ...$p);
    }
    $st->execute();
    return $st;
}
function rows(string $sql, array $p = []): array {
    $st = q($sql, $p);
    $r = $st->get_result()->fetch_all(MYSQLI_ASSOC);
    $st->close();
    return $r;
}
function row(string $sql, array $p = []): ?array { return rows($sql, $p)[0] ?? null; }
function val(string $sql, array $p = []) { $r = row($sql, $p); return $r ? array_values($r)[0] : null; }
function run(string $sql, array $p = []): int {
    $st = q($sql, $p);
    $n = $st->affected_rows;
    $st->close();
    return $n;
}

/* ---------- misc helpers ---------- */
function e($s): string { return htmlspecialchars((string)$s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); }
function json_out(array $d, int $code = 200): void {
    http_response_code($code);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($d, JSON_UNESCAPED_UNICODE);
    exit;
}
function kebab(string $s): string { return strtolower(preg_replace('/([a-z])([A-Z0-9])/', '$1-$2', $s)); }
function media_url(?string $p): string {
    $p = (string)$p;
    return (preg_match('~^(https?:)?//~', $p) || $p === '') ? $p : $p;
}
function csrf_token(): string {
    if (empty($_SESSION['csrf'])) $_SESSION['csrf'] = bin2hex(random_bytes(32));
    return $_SESSION['csrf'];
}
function csrf_verify(): void {
    $t = $_SERVER['HTTP_X_CSRF_TOKEN'] ?? ($_POST['csrf'] ?? '');
    if (!hash_equals(csrf_token(), (string)$t)) {
        json_out(['ok' => false, 'error' => 'Invalid security token. Please refresh the page.'], 419);
    }
}
function require_login(bool $json = false): void {
    $expired = empty($_SESSION['admin_id']) || (time() - ($_SESSION['last'] ?? 0)) > SESSION_TIMEOUT;
    if ($expired) {
        $_SESSION = [];
        if ($json) json_out(['ok' => false, 'error' => 'Session expired'], 401);
        header('Location: login.php');
        exit;
    }
    $_SESSION['last'] = time();
}

/* Deletes the cached public site data so the next visit rebuilds it from the database. */
function clear_site_cache(): void {
    foreach (glob(__DIR__ . '/cache/site-*.json') ?: [] as $f) {
        @unlink($f);
    }
}
function log_activity(string $action, string $details = ''): void {
    clear_site_cache(); // any admin action may have changed site data
    try {
        run('INSERT INTO activity_log (admin_id, action, details) VALUES (?,?,?)',
            [$_SESSION['admin_id'] ?? null, $action, mb_substr($details, 0, 480)]);
    } catch (Throwable $e) { /* never break a request because of logging */ }
}
function ensure_default_admin(): void {
    if ((int)val('SELECT COUNT(*) FROM admins') === 0) {
        run('INSERT INTO admins (username, password_hash, email) VALUES (?,?,?)',
            ['admin', password_hash('admin123', PASSWORD_DEFAULT), '']);
    }
}

/* ---------- uploads ---------- */
function handle_upload(array $file, string $dir): string {
    if ($file['error'] !== UPLOAD_ERR_OK) throw new RuntimeException('Upload failed (code ' . $file['error'] . ')');
    if ($file['size'] > MAX_UPLOAD_BYTES) throw new RuntimeException('Image is larger than 5 MB');
    $mime = (new finfo(FILEINFO_MIME_TYPE))->file($file['tmp_name']);
    $ext = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp', 'image/gif' => 'gif'][$mime] ?? null;
    if (!$ext) throw new RuntimeException('Only JPG, PNG, WEBP or GIF images are allowed');
    $dir = preg_replace('/[^a-z0-9_-]/i', '', $dir) ?: 'misc';
    $target = UPLOAD_PATH . $dir . '/';
    if (!is_dir($target)) mkdir($target, 0775, true);
    $name = bin2hex(random_bytes(8)) . '.' . $ext;
    if (!move_uploaded_file($file['tmp_name'], $target . $name)) throw new RuntimeException('Could not save the file');
    return 'uploads/' . $dir . '/' . $name;
}

/* ---------- module / settings configuration ---------- */
function fld(string $name, string $label, string $type = 'text', array $o = []): array {
    return ['name' => $name, 'label' => $label, 'type' => $type] + $o;
}
function modules(): array {
    static $m = null;
    return $m ??= require __DIR__ . '/includes/modules.php';
}
function settings_groups(): array {
    return [
        'contact' => ['title' => 'Contact info', 'table' => 'contact_info', 'dir' => 'about', 'fields' => [
            fld('phone', 'Phone'),
            fld('email', 'Email', 'email'),
            fld('address', 'Address', 'textarea'),
            fld('map_url', 'Map URL (embed link)', 'url'),
            fld('working_hours', 'Working hours'),
        ]],
        'about' => ['title' => 'About / Vision', 'table' => 'about_content', 'dir' => 'about', 'fields' => [
            fld('title', 'Section title'),
            fld('description', 'Description', 'textarea'),
            fld('image_url', 'Image', 'image'),
            fld('mission', 'Mission', 'textarea'),
            fld('vision', 'Vision statement (visionStatement)', 'textarea'),
        ]],
        'general' => ['title' => 'General & social', 'kv' => true, 'fields' => [
            fld('site_name', 'Site name'),
            fld('tagline', 'Tagline'),
            fld('facebook', 'Facebook URL', 'url'),
            fld('twitter', 'X / Twitter URL', 'url'),
            fld('linkedin', 'LinkedIn URL', 'url'),
            fld('instagram', 'Instagram URL', 'url'),
            fld('whatsapp', 'WhatsApp number / link'),
        ]],
    ];
}
function icon_list(): array {
    return ['Award','Bean','BarChart3','Beaker','Bot','Boxes','Candy','CircleDot','Coffee','Container','Cookie',
        'Droplet','Droplets','FlaskConical','Handshake','Layers','Leaf','Megaphone','MessageSquare',
        'MonitorSmartphone','Nut','Palette','Radar','Recycle','Scroll','ShieldCheck','ShoppingBag','Sparkles',
        'Sprout','Target','TrendingUp','Users','Video','Wand2','Wheat','Zap','Globe','Package','Clock','Star'];
}