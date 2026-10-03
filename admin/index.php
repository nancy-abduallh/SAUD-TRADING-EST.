<?php
require_once __DIR__ . '/auth.php';
$pageTitle = 'Dashboard';
$active = 'index';
$useCharts = true;

$kpis = [
    ['Hero Slides', 'hero_slides', 'hero.php', 'image'],
    ['Sectors', 'sectors', 'services.php', 'layers'],
    ['Categories', 'categories', 'categories.php', 'folder'],
    ['Products', 'products', 'products.php', 'package'],
    ['Clients', 'clients', 'clients.php', 'handshake'],
    ['Brands', 'brands', 'brands.php', 'award'],
    ['Testimonials', 'testimonials', 'testimonials.php', 'quote'],
    ['Countries', 'countries', 'countries.php', 'globe'],
];
$counts = [];
foreach ($kpis as $k) $counts[$k[1]] = (int)val("SELECT COUNT(*) FROM `{$k[1]}`");
$unread = (int)val('SELECT COUNT(*) FROM contact_messages WHERE is_read = 0');

// Messages per month (last 6)
$months = [];
for ($i = 5; $i >= 0; $i--) $months[date('Y-m', strtotime("first day of -$i month"))] = 0;
foreach (rows("SELECT DATE_FORMAT(created_at,'%Y-%m') ym, COUNT(*) c FROM contact_messages
               WHERE created_at >= DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL 5 MONTH), '%Y-%m-01') GROUP BY ym") as $r) {
    if (isset($months[$r['ym']])) $months[$r['ym']] = (int)$r['c'];
}
$perCat = rows('SELECT c.name, COUNT(p.id) n FROM categories c LEFT JOIN products p ON p.category_id = c.id
                GROUP BY c.id ORDER BY c.sector_id, c.sort_order');
$perSector = rows('SELECT s.title, COUNT(p.id) n FROM sectors s LEFT JOIN categories c ON c.sector_id = s.id
                   LEFT JOIN products p ON p.category_id = c.id GROUP BY s.id ORDER BY s.sort_order');
$ratings = array_fill(1, 5, 0);
foreach (rows('SELECT rating, COUNT(*) n FROM testimonials GROUP BY rating') as $r) $ratings[(int)$r['rating']] = (int)$r['n'];

$activity = rows('SELECT l.*, a.username FROM activity_log l LEFT JOIN admins a ON a.id = l.admin_id ORDER BY l.id DESC LIMIT 8');

// site-data sync check (expected counts from site-data)
$expected = ['hero_slides' => 3, 'sectors' => 3, 'categories' => 13, 'products' => 57, 'site_values' => 6, 'digital_ecosystem' => 4,
    'comparison_rows' => 4, 'clients' => 11, 'countries' => 3, 'stats' => 4];
$sync = [];
foreach ($expected as $t => $n) $sync[$t] = [$n, (int)val("SELECT COUNT(*) FROM `$t`")];

$defaultPw = password_verify('admin123', (string)val('SELECT password_hash FROM admins WHERE id = ?', [(int)$ADMIN['id']]));

require __DIR__ . '/includes/header.php';
?>
<?php if ($defaultPw): ?>
  <div class="alert warn"><?= e(__('default_password_warning')) ?> <a href="profile.php"><b><?= e(__('change_password_link')) ?></b></a></div>
<?php endif; ?>

<div class="kpi-grid">
  <?php foreach ($kpis as $k): ?>
    <a class="card kpi glow-hover" href="<?= e($k[2]) ?>">
      <span class="kpi-ic"><i data-lucide="<?= e($k[3]) ?>"></i></span>
      <div><div class="kpi-n" data-count="<?= $counts[$k[1]] ?>">0</div><div class="muted"><?= e(__($k[0])) ?></div></div>
    </a>
  <?php endforeach; ?>
  <a class="card kpi glow-hover<?= $unread ? ' alert-kpi' : '' ?>" href="messages.php">
    <span class="kpi-ic"><i data-lucide="mail"></i></span>
    <div><div class="kpi-n" data-count="<?= $unread ?>">0</div><div class="muted"><?= e(__('Unread messages')) ?></div></div>
  </a>
</div>

<div class="grid-2">
  <div class="card pad"><h3><?= e(__('Messages · last 6 months')) ?></h3><div class="chart-box"><canvas id="chMsgs"></canvas></div></div>
  <div class="card pad"><h3><?= e(__('Products per sector')) ?></h3><div class="chart-box"><canvas id="chSector"></canvas></div></div>
</div>
<div class="grid-2">
  <div class="card pad"><h3><?= e(__('Products per category')) ?></h3><div class="chart-box tall"><canvas id="chCat"></canvas></div></div>
  <div class="card pad"><h3><?= e(__('Testimonial ratings')) ?></h3><div class="chart-box"><canvas id="chRate"></canvas></div></div>
</div>

<div class="grid-3">
  <div class="card pad">
    <h3><?= e(__('Quick actions')) ?></h3>
    <div class="quick">
      <a class="btn" href="products.php"><i data-lucide="plus"></i> <?= e(__('Product')) ?></a>
      <a class="btn" href="clients.php"><i data-lucide="plus"></i> <?= e(__('Client')) ?></a>
      <a class="btn" href="hero.php"><i data-lucide="plus"></i> <?= e(__('Hero slide')) ?></a>
      <a class="btn" href="faqs.php"><i data-lucide="plus"></i> <?= e(__('FAQ')) ?></a>
      <a class="btn" href="settings.php"><i data-lucide="settings"></i> <?= e(__('Settings')) ?></a>
      <a class="btn" href="public_api.php" target="_blank"><i data-lucide="code"></i> <?= e(__('JSON API')) ?></a>
    </div>
    <h3 class="mt"><?= e(__('System status')) ?></h3>
    <ul class="status">
      <li><span class="ok"></span> MySQL <?= e(db()->server_info) ?></li>
      <li><span class="<?= PHP_VERSION_ID >= 80000 ? 'ok' : 'bad' ?>"></span> PHP <?= e(PHP_VERSION) ?></li>
      <li><span class="<?= is_writable(UPLOAD_PATH) ? 'ok' : 'bad' ?>"></span> uploads/ <?= is_writable(UPLOAD_PATH) ? e(__('writable', 'writable')) : e(__('not_writable', 'NOT writable')) ?></li>
      <li><span class="<?= extension_loaded('fileinfo') ? 'ok' : 'bad' ?>"></span> fileinfo extension</li>
    </ul>
  </div>
  <div class="card pad">
    <h3><?= e(__('Site-data sync')) ?></h3>
    <table class="data-table compact">
      <thead><tr><th><?= e(__('Table')) ?></th><th><?= e(__('Expected')) ?></th><th><?= e(__('In DB')) ?></th><th></th></tr></thead>
      <tbody>
      <?php foreach ($sync as $t => [$exp, $got]): ?>
        <tr><td><?= e($t) ?></td><td><?= $exp ?></td><td><?= $got ?></td>
            <td><?= $got >= $exp ? '<span class="tick">✓</span>' : '<span class="cross">✗ ' . e(__('missing')) . '</span>' ?></td></tr>
      <?php endforeach; ?>
      </tbody>
    </table>
  </div>
  <div class="card pad">
    <h3><?= e(__('Recent activity')) ?></h3>
    <ul class="feed">
      <?php foreach ($activity as $a): ?>
        <li><b><?= e($a['action']) ?></b> <span class="muted" dir="auto"><?= e($a['details']) ?></span>
            <small class="muted"><?= e($a['username'] ?? 'system') ?> · <?= e($a['created_at']) ?></small></li>
      <?php endforeach; ?>
      <?php if (!$activity): ?><li class="muted"><?= e(__('No activity yet.')) ?></li><?php endif; ?>
    </ul>
  </div>
</div>

<script>
window.DASH = {
  msgs: { labels: <?= json_encode(array_keys($months)) ?>, data: <?= json_encode(array_values($months)) ?> },
  perCat: { labels: <?= json_encode(array_column($perCat, 'name'), JSON_UNESCAPED_UNICODE) ?>, data: <?= json_encode(array_map('intval', array_column($perCat, 'n'))) ?> },
  perSector: { labels: <?= json_encode(array_column($perSector, 'title'), JSON_UNESCAPED_UNICODE) ?>, data: <?= json_encode(array_map('intval', array_column($perSector, 'n'))) ?> },
  ratings: <?= json_encode(array_values($ratings)) ?>
};
</script>
<?php require __DIR__ . '/includes/footer.php'; ?>