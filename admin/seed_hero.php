<?php
require_once __DIR__ . '/config.php';

header('Content-Type: application/json; charset=utf-8');

$heroUploadDir = __DIR__ . '/uploads/hero/';
if (!is_dir($heroUploadDir)) {
    mkdir($heroUploadDir, 0775, true);
}

// Copy hero images from src/assets/ to admin/uploads/hero/
$srcAssets = dirname(__DIR__) . '/src/assets/';
$filesToCopy = [
    'hero-port.jpg' => $srcAssets . 'hero-port.jpg',
    'hero-skyline.jpg' => $srcAssets . 'hero-skyline.jpg',
    'hero-globe.jpg' => $srcAssets . 'hero-globe.jpg',
];

$copied = [];
foreach ($filesToCopy as $filename => $sourcePath) {
    $destPath = $heroUploadDir . $filename;
    if (file_exists($sourcePath) && (!file_exists($destPath) || filesize($destPath) !== filesize($sourcePath))) {
        copy($sourcePath, $destPath);
        $copied[] = $filename;
    }
}

// Also copy favicon to admin/
$srcFavicon = dirname(__DIR__) . '/public/favicon.ico';
if (file_exists($srcFavicon)) {
    copy($srcFavicon, __DIR__ . '/favicon.ico');
}

// Clear existing hero_slides or update
run('TRUNCATE TABLE hero_slides');

$slides = [
    [
        'title' => 'نربط العالم بأمانة سعودية',
        'subtitle' => 'ريادة التجارة العالمية',
        'description' => 'حلول متكاملة لسلاسل الإمداد، من المواد الخام البلاستيكية إلى أجود أنواع الأغذية العالمية، بمعايير تتجاوز التوقعات.',
        'image_url' => 'uploads/hero/hero-port.jpg',
        'cta_text' => 'استكشف قطاعاتنا',
        'cta_link' => '#sectors',
        'sort_order' => 1,
        'is_active' => 1,
    ],
    [
        'title' => 'رؤية سعودية تتجاوز الحدود',
        'subtitle' => 'رؤية سعودية عالمية',
        'description' => 'من قلب المملكة إلى أسواق مصر والإمارات، نبني منظومة تجارية ورقمية متكاملة تواكب رؤية 2030.',
        'image_url' => 'uploads/hero/hero-skyline.jpg',
        'cta_text' => 'عن سعود التجارية',
        'cta_link' => '#about',
        'sort_order' => 2,
        'is_active' => 1,
    ],
    [
        'title' => 'شبكة عالمية من الشركاء والموارد',
        'subtitle' => 'شبكة مترابطة',
        'description' => 'أكثر من 45 سوقاً دولياً ومنظومة رقمية مدعومة بالذكاء الاصطناعي تربطك بعملائك أينما كانوا.',
        'image_url' => 'uploads/hero/hero-globe.jpg',
        'cta_text' => 'تواصل معنا',
        'cta_link' => '#contact',
        'sort_order' => 3,
        'is_active' => 1,
    ],
];

foreach ($slides as $s) {
    run(
        'INSERT INTO hero_slides (title, subtitle, description, image_url, cta_text, cta_link, sort_order, is_active) VALUES (?, ?, ?, ?, ?, ?, ?, ?)',
        [
            $s['title'],
            $s['subtitle'],
            $s['description'],
            $s['image_url'],
            $s['cta_text'],
            $s['cta_link'],
            $s['sort_order'],
            $s['is_active']
        ]
    );
}

clear_site_cache();

$inserted = rows('SELECT * FROM hero_slides ORDER BY sort_order');

echo json_encode([
    'ok' => true,
    'copied_images' => $copied,
    'slides_count' => count($inserted),
    'slides' => $inserted
], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
