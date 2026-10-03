<?php
define('NO_SESSION', true); 
require __DIR__ . '/config.php';

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Content-Type: application/json; charset=utf-8');
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') exit;

/* ---- contact form ---- */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $in = json_decode(file_get_contents('php://input') ?: '', true) ?: $_POST;
    if (!empty($in['website'])) json_out(['ok' => true]); // honeypot
    $name = trim((string)($in['name'] ?? ''));
    $email = trim((string)($in['email'] ?? ''));
    $msg = trim((string)($in['message'] ?? ''));
    if ($name === '' || $msg === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        json_out(['ok' => false, 'error' => 'Name, valid email and message are required'], 422);
    }
    run('INSERT INTO contact_messages (name, email, phone, subject, message) VALUES (?,?,?,?,?)', [
        mb_substr($name, 0, 150), mb_substr($email, 0, 150),
        mb_substr(trim((string)($in['phone'] ?? '')), 0, 50),
        mb_substr(trim((string)($in['subject'] ?? '')), 0, 255), mb_substr($msg, 0, 5000),
    ]);
    json_out(['ok' => true]);
}

/* ---- cache: reuse the last result for 5 minutes ---- */
$cacheDir = __DIR__ . '/cache/';
$cacheFile = $cacheDir . 'site-' . md5($_SERVER['HTTP_HOST'] ?? 'local') . '.json';
if (is_file($cacheFile) && (time() - filemtime($cacheFile)) < 300) {
    readfile($cacheFile);
    exit;
}

/* ---- full site data (same shape as site-data) ---- */
$base = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST']
    . rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'])), '/') . '/';
$img = fn($p) => $p === '' || $p === null ? '' : (preg_match('~^https?://~', $p) ? $p : $base . $p);

$sectors = [];
foreach (rows('SELECT * FROM sectors ORDER BY sort_order, id') as $s) {
    $sectors[$s['slug']] = [
        'title' => $s['title'], 'english' => $s['english'], 'description' => (string)$s['description'],
        'image' => $img($s['image']), 'imageAlt' => $s['image_alt'],
        'categories' => array_column(rows('SELECT name FROM categories WHERE sector_id = ? ORDER BY sort_order, id', [(int)$s['id']]), 'name'),
    ];
}

$products = [];
foreach (rows('SELECT p.*, c.name AS cat FROM products p JOIN categories c ON c.id = p.category_id
               WHERE p.is_active = 1 ORDER BY c.sector_id, c.sort_order, c.id, p.sort_order, p.id') as $p) {
    $products[$p['cat']][] = ['name' => $p['name'], 'icon' => $p['icon'], 'blurb' => (string)$p['blurb'], 'image' => $img($p['image'])];
}

$settings = array_column(rows('SELECT setting_key, setting_value FROM site_settings'), 'setting_value', 'setting_key');
$about = row('SELECT * FROM about_content WHERE id = 1') ?: [];

$json = json_encode([
    'sectors' => $sectors,
    'products' => $products,
    'visionStatement' => (string)($about['vision'] ?? ''),
    'values' => array_map(fn($r) => ['title' => $r['title'], 'description' => (string)$r['description'], 'icon' => $r['icon']],
        rows('SELECT * FROM site_values ORDER BY sort_order, id')),
    'digitalEcosystem' => array_map(fn($r) => ['title' => $r['title'], 'description' => (string)$r['description'], 'icon' => $r['icon']],
        rows('SELECT * FROM digital_ecosystem ORDER BY sort_order, id')),
    'comparisonRows' => array_map(fn($r) => ['label' => $r['label'], 'traditional' => $r['traditional'], 'smart' => $r['smart']],
        rows('SELECT * FROM comparison_rows ORDER BY sort_order, id')),
    'clients' => array_map(fn($r) => ['name' => $r['name'], 'logo' => $img($r['logo_url'])],
        rows('SELECT * FROM clients WHERE is_active = 1 ORDER BY sort_order, id')),
    'countries' => array_map(fn($r) => ['name' => $r['name'], 'english' => $r['english']],
        rows('SELECT * FROM countries ORDER BY sort_order, id')),
    'stats' => array_map(fn($r) => [$r['value'], $r['label']], rows('SELECT * FROM stats ORDER BY sort_order, id')),
    'about' => $about ? ['title' => $about['title'], 'description' => (string)$about['description'],
        'image' => $img($about['image_url']), 'mission' => (string)$about['mission']] : null,
    'contact' => row('SELECT phone, email, address, map_url AS mapUrl, working_hours AS workingHours FROM contact_info WHERE id = 1'),
    'settings' => $settings,
    'brands' => array_map(fn($r) => ['name' => $r['name'], 'logo' => $img($r['logo_url']), 'url' => $r['website_url']],
        rows('SELECT * FROM brands WHERE is_active = 1 ORDER BY sort_order, id')),
    'heroSlides' => array_map(fn($r) => ['title' => $r['title'], 'subtitle' => $r['subtitle'], 'description' => (string)$r['description'],
        'image' => $img($r['image_url']), 'ctaText' => $r['cta_text'], 'ctaLink' => $r['cta_link']],
        rows('SELECT * FROM hero_slides WHERE is_active = 1 ORDER BY sort_order, id')),
    'testimonials' => array_map(fn($r) => ['name' => $r['client_name'], 'position' => $r['client_position'], 'company' => $r['client_company'],
        'content' => (string)$r['content'], 'avatar' => $img($r['avatar_url']), 'rating' => (int)$r['rating']],
        rows('SELECT * FROM testimonials WHERE is_active = 1 ORDER BY id DESC')),
    'faqs' => array_map(fn($r) => ['question' => $r['question'], 'answer' => (string)$r['answer']],
        rows('SELECT * FROM faqs WHERE is_active = 1 ORDER BY sort_order, id')),
], JSON_UNESCAPED_UNICODE);

if ($json === false) json_out(['ok' => false, 'error' => 'Could not encode site data'], 500);

if (!is_dir($cacheDir)) @mkdir($cacheDir, 0775, true);
@file_put_contents($cacheFile, $json, LOCK_EX);
echo $json;