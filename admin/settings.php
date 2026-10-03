<?php
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/includes/ui.php';
$pageTitle = 'Settings';
$active = 'settings';

$groups = settings_groups();
$vals = [
    'contact' => row('SELECT * FROM contact_info WHERE id = 1') ?: [],
    'about' => row('SELECT * FROM about_content WHERE id = 1') ?: [],
    'general' => array_column(rows('SELECT setting_key, setting_value FROM site_settings'), 'setting_value', 'setting_key'),
];

require __DIR__ . '/includes/header.php';
?>
<div class="page-head">
  <div><h2><?= e(__('Site settings')) ?></h2><p class="muted"><?= e(__('site_settings_sub')) ?></p></div>
  <div class="tabs">
    <?php $first = true; foreach ($groups as $key => $g): ?>
      <button class="<?= $first ? 'active' : '' ?>" data-pane="pane-<?= e($key) ?>"><?= e(__($g['title'])) ?></button>
    <?php $first = false; endforeach; ?>
  </div>
</div>

<?php $first = true; foreach ($groups as $key => $g): ?>
  <div class="card pad pane<?= $first ? ' active' : '' ?>" id="pane-<?= e($key) ?>">
    <form data-action="save_settings" data-group="<?= e($key) ?>" enctype="multipart/form-data">
      <div class="form-grid">
        <?php foreach ($g['fields'] as $f) render_field($f, [], $vals[$key][$f['name']] ?? ''); ?>
      </div>
      <div class="modal-foot"><button class="btn btn-primary" type="submit"><?= e(__('Save')) ?> <?= e(__($g['title'])) ?></button></div>
    </form>
  </div>
<?php $first = false; endforeach; ?>

<div class="card pad mt">
  <h3><?= e(__('Managed on their own pages')) ?></h3>
  <div class="quick">
    <a class="btn" href="stats.php"><i data-lucide="trending-up"></i> <?= e(__('Stats')) ?></a>
    <a class="btn" href="countries.php"><i data-lucide="globe"></i> <?= e(__('Countries')) ?></a>
    <a class="btn" href="values.php"><i data-lucide="sparkles"></i> <?= e(__('Values')) ?></a>
    <a class="btn" href="ecosystem.php"><i data-lucide="bot"></i> <?= e(__('Digital Ecosystem')) ?></a>
    <a class="btn" href="comparison.php"><i data-lucide="table"></i> <?= e(__('Comparison Table')) ?></a>
  </div>
</div>
<?php require __DIR__ . '/includes/footer.php'; ?>